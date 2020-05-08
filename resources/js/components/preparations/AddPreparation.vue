<template>
  <div>
    <div class="panel-heading" style="border-bottom: 0px; margin-left: -15px; margin-top: -30px;">
      <h3 class="panel-title">Add Preparation</h3>
    </div>

    <form method="POST" @submit.prevent="addPreparation">
      <textarea v-model="step" class="form-control" rows="3" spellcheck="false"></textarea>
      <div class="text-right">
        <button type="submit" style="margin-top:15px;" class="btn btn-default btn-sm">Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
import gql from "graphql-tag";
import CreatePreparation from "../../../gql/mutations/preparations/CreatePreparation.gql";

export default {
  props: ["recipeid"],
  data() {
    return {
      step: "",
      author_id: 1,
      order: 1
    };
  },
  methods: {
    addPreparation() {
      this.$apollo
        .mutate({
          // Query
          mutation: CreatePreparation,
          // Parameters
          variables: {
            step: this.step,
            recipe_id: this.recipeid,
            author_id: this.author_id,
            order: this.order
          }
        })
        .then(data => {
          if (data) {
            this.step = "";
            this.$store.commit('updateNewPrepStatus', 'add')
          }
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
};
</script>
