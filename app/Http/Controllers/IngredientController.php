<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Recipeingredient;
use \App\Recipe;

class IngredientController extends Controller
{
    public function store(Request $request)
    {

        $data = $request->validate([
            'amount' => 'required',
            'ingredient' => 'required',
        ]);

        $ingredient = Recipeingredient::create([
            'author_id' => auth()->user()->id,
            'amount' => $request->amount,
            'ingredient_id' => $request->ingredient,
            'note' => $request->note,
            'recipe_id' => $request->recipe_id
        ]);

        $recipe = Recipe::findOrFail($request->recipe_id);
        $recipe->categories()->syncWithoutDetaching($request->ingredient);

        return response()->json([
            "success"=> 201,
            "recipe_ingredient" => $ingredient,
            "ingredient" => $ingredient->ingredient
        ]);
    }

    public function update(Request $request, $id)
    {

        $ingredient = Recipeingredient::findOrFail($id);
        $ingredient->amount = $request->amount;
        $ingredient->ingredient_id = $ingredient;
        $ingredient->note = $request->note;
        $ingredient->save();
        return response()->json([
            "updated" => 201,
            "recipe_ingredient" => $ingredient,
            "ingredient" => $ingredient->ingredient
        ]);
    }

    public function delete($id)
    {
        $ingredient = Recipeingredient::find($id);
        $recipe = Recipe::findOrFail($ingredient->recipe_id);
        $recipe->categories()->detach($ingredient->ingredient->id);
        $ingredient->delete();
        return response("Ingredient deleted.", 201);
    }
}
