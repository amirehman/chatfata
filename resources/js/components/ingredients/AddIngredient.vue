<template>
  <div>
    <div class="panel-heading" style="border-bottom: 0px; margin-left: -15px; margin-top: -30px;">
      <h3 class="panel-title">Add Ingredient</h3>
    </div>

    <form method="POST" @submit.prevent="addIngredient">
      <div class="row">
        <div class="col-lg-2" style="padding-right:0px; margin-bottom: 0px;">
          <label for>Amount</label>
          <input v-model="amount" class="form-control" spellcheck="false" />
        </div>
        <div class="col-lg-3" style="padding-right:0px; margin-bottom: 0px;">
          <label for>Ingredient</label>
        <v-select :options="ingredients" v-model="ingredient" :reduce="ingredient => ingredient.id" label="title" />

        </div>
        <div class="col-lg-7" style="margin-bottom: 0px;">
          <label for>Note</label>
          <input v-model="note" class="form-control" spellcheck="false" />
        </div>
      </div>
      <div class="text-right">
        <button type="submit" style="margin-top:15px;" class="btn btn-default btn-sm">Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
import gql from "graphql-tag";
import CreateIngredient from "../../../gql/mutations/ingredients/createRecipeingredients.gql";
import ingredientsQuery from "../../../gql/queries/Ingredients.gql";

export default {
  props: ["recipeid"],
  data() {
    return {
      amount: "",
      ingredient: "",
      note: "",
      author_id: 1,
      order: 1,
      ingredientsArray: []
    };
  },
  methods: {
    addIngredient() {
      this.$apollo
        .mutate({
          // Query
          mutation: CreateIngredient,
          // Parameters
          variables: {
            amount: this.amount,
            note: this.note,
            ingredient_id: this.ingredient,
            recipe_id: this.recipeid,
            author_id: this.author_id,
            order: this.order
          }
        })
        .then(data => {
          if (data) {
            this.amount = "";
            this.note = "";
            this.ingredient = "";
            this.$store.commit("updateNewIngredientStatus", "add");
          }
        })
        .catch(error => {
          console.error(error);
        });
    }
  },
  apollo: {
    ingredients: {
      query: ingredientsQuery,
      update: data => data.ingredients
    }
  }
};
</script>


<style>
.vs__select .vs__search {
  line-height: 1.5 !important;
}
</style>
