<template>
  <div>
    <div class="panel-heading" style="border-bottom: 0px; margin-left: -15px; margin-top: -30px;">
      <h3 class="panel-title">Edit Preparation</h3>
    </div>

    <form method="POST" @submit.prevent="updatePreparation">
      <textarea v-model="updatedStep.step" class="form-control" rows="3" spellcheck="false"></textarea>
      <div class="text-right">
        <span @click="cancelEditing" style="margin-top:15px;" class="btn btn-default btn-sm">Cancel</span>
        <button type="submit" style="margin-top:15px;" class="btn btn-default btn-sm">Update</button>
      </div>
    </form>
  </div>
</template>

<script>
import gql from "graphql-tag";
import UpdatedPreparation from "../../../gql/mutations/preparations/UpdatedPreparation.gql";

export default {
  props: ["recipeid"],
  data() {
    return {
      author_id: 1,
      step: ''
    };
  },
  computed: {
    updatedStep: {
      get: function() {
        return this.$store.state.step;
      },
      set: function(newValue) {}
    }
  },
  methods: {
    cancelEditing () {
      this.$store.commit('updateIsEditingPrepStep',false);
    },
    updatePreparation() {
      this.$apollo
        .mutate({
          // Query
          mutation: UpdatedPreparation,
          // Parameters
          variables: {
            id: this.updatedStep.id,
            step: this.updatedStep.step,
            recipe_id: this.recipeid,
            author_id: this.author_id
          }
        })
        .then(data => {
          if (data) {
          this.$store.commit('updateIsEditingPrepStep',false);
          }
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
};
</script>
