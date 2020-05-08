<template>
  <div>
    <div class="panel-body">
      <!-- @update-number="editPreparation" -->
      <edit-preparation v-if="isEditing" :recipeid="recipeid" :step="step"></edit-preparation>
      <add-preparation v-else :recipeid="recipeid"></add-preparation>
      <div class="table-responsive" style="margin-top: 30px;">
        <table class="table">
          <caption class>
            <h4>Preparations steps</h4>
          </caption>
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Step</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(step, i) in GetAllPreparationsByRecipe" :key="i">
              <th scope="row">{{ i + 1}}</th>
              <td>{{ step.step }}</td>
              <td>
                <button
                  type="button"
                  style="padding: 0px 5px; font-size: 12px;"
                  @click="editPreparation(step)"
                  class="btn btn-info btn-sm"
                >Edit</button>
                <button
                  type="button"
                  style="padding: 0px 5px; font-size: 12px;"
                  class="btn btn-danger btn-sm"
                  @click.prevent="deleteAlert(i, step.id)"
                >Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import gql from "graphql-tag";

import preparationsQuery from "../../../gql/queries/GetAllPreparationsByRecipe.gql";
import deletePreparation from "../../../gql/mutations/preparations/deletePreparations.gql";

export default {
  props: ["recipeid"],
  data() {
    return {
      step: []
    };
  },
  computed: {
    isEditing() {
      return this.$store.state.isEditingPrepStep;
    },
    watchForPrepChanges () {
      return this.$store.state.newPrepStatus;
    }
  },
  watch: {
    watchForPrepChanges: function(newvalue, old) {
      if (newvalue > old) {
        // this.megaMenuAnimation();
        this.$apollo.queries.GetAllPreparationsByRecipe.skip = false
        this.$apollo.queries.GetAllPreparationsByRecipe.refetch()
      }
    }
  },
  methods: {
    deleteAlert(key, id) {
      // Use sweetalert2
      this.$swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          if (result.value) {
            this.deletePreparation(key,id)
            this.$swal.fire("Deleted!", "the step has been deleted.", "success");
          }
        });
    },
    deletePreparation(key, id) {
      this.GetAllPreparationsByRecipe.splice(key, 1);
      this.$apollo
        .mutate({
          mutation: deletePreparation,
          variables: {
            id: id
          }
        })
        .then(data => {
          return data
        });
    },
    editPreparation(step) {
      this.$store.commit("updateIsEditingPrepStep", true);
      this.$store.commit("updateStep", step);
    }
  },
  apollo: {
    GetAllPreparationsByRecipe: {
      query: preparationsQuery,
      variables() {
        return {
          id: this.recipeid
        };
      }
    }
  }
};
</script>
