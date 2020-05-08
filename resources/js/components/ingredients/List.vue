<template>
  <div>
    <div class="panel-body">
      <!-- @update-number="editPreparation" -->
      <edit-ingredient v-if="isEditing" :recipeid="recipeid" :ingredient="ingredient"></edit-ingredient>
      <add-ingredient v-else :recipeid="recipeid"></add-ingredient>
      <div class="table-responsive" style="margin-top: 30px;">
        <table class="table">
          <caption class>
            <h4>Ingredients</h4>
          </caption>
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Amount</th>
              <th scope="col">Ingredient</th>
              <th scope="col">Note</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(ingredient, i) in GetAllIngredientsByRecipe" :key="i">
              <th scope="row">{{ i + 1}}</th>
              <td>{{ ingredient.amount }}</td>
              <td>{{ ingredient.ingredient.title }}</td>
              <td>{{ ingredient.note }}</td>
              <td>
                <button
                  type="button"
                  @click="editPreparation(ingredient)"
                  class="btn btn-info"
                  style="padding: 0px 5px; font-size: 12px;"
                >Edit</button>
                <button
                  type="button"
                  class="btn btn-danger"
                  style="padding: 0px 5px; font-size: 12px;"
                  @click.prevent="deleteAlert(i, ingredient.id)"
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

import recipeIngredientQuery from "../../../gql/queries/GetAllIngredientsByRecipe.gql";
import deleteIngredient from "../../../gql/mutations/ingredients/deleteRecipeingredients.gql";

export default {
  props: ["recipeid"],
  data() {
    return {
      ingredient: []
    };
  },
  computed: {
    isEditing() {
      return this.$store.state.isEditingPrepIngredient;
    },
    watchForIngredientChanges() {
      return this.$store.state.newIngredientStatus;
    }
  },
  watch: {
    watchForIngredientChanges: function(newvalue, old) {
      if (newvalue > old) {
        // this.megaMenuAnimation();
        this.$apollo.queries.GetAllIngredientsByRecipe.refetch();
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
            this.deleteIngredient(key, id);
            this.$swal.fire(
              "Deleted!",
              "Ingredient has been deleted.",
              "success"
            );
          }
        });
    },
    deleteIngredient(key, id) {
      this.GetAllIngredientsByRecipe.splice(key, 1);
      this.$apollo
        .mutate({
          mutation: deleteIngredient,
          variables: {
            id: id
          }
        })
        .then(data => {
          return data;
        });
    },
    editPreparation(ingredient) {
      this.$store.commit("updateIsEditingIngredient", true);
      this.$store.commit("updateIngredient", ingredient);
    }
  },
  apollo: {
    GetAllIngredientsByRecipe: {
      query: recipeIngredientQuery,
      variables() {
        return {
          id: this.recipeid
        };
      }
    }
  }
};
</script>
