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

        $count = count(Recipeingredient::where('recipe_id', $request->recipe_id)->get());

        $ingredient = Recipeingredient::create([
            'author_id' => auth()->user()->id,
            'amount' => $request->amount,
            'ingredient_id' => $request->ingredient,
            'note' => $request->note,
            'recipe_id' => $request->recipe_id,
            'order' => $count
        ]);

        $recipe = Recipe::findOrFail($request->recipe_id);
        $recipe->categories()->syncWithoutDetaching($request->ingredient);

        return response()->json([
            "success" => 201,
            "recipe_ingredient" => $ingredient,
            "ingredient" => $ingredient->ingredient
        ]);
    }
    public function storeHeading(Request $request)
    {

        $data = $request->validate([
            'amount' => 'required',
        ]);

        $count = count(Recipeingredient::where('recipe_id', $request->recipe_id)->get());

        $ingredient = Recipeingredient::create([
            'author_id' => auth()->user()->id,
            'amount' => $request->amount,
            'ingredient_id' => 0,
            'type' => 'heading',
            'recipe_id' => $request->recipe_id,
            'order' => $count
        ]);

        return response()->json([
            "success" => 201,
            "recipe_ingredient" => $ingredient,
        ]);
    }

    public function update(Request $request, $id)
    {

        $ingredient = Recipeingredient::findOrFail($id);
        $ingredient->amount = $request->amount;
        $ingredient->ingredient_id = $request->ingredient;
        $ingredient->note = $request->note;



        $recipe = Recipe::findOrFail($ingredient->recipe_id);
        $recipe->categories()->syncWithoutDetaching($request->ingredient);

        $ingredient->save();


        return response()->json([
            "updated" => 201,
            "recipe_ingredient" => $ingredient,
            "ingredient" => $ingredient->ingredient
        ]);
    }

    public function updateHeading(Request $request, $id)
    {

        $ingredient = Recipeingredient::findOrFail($id);
        $ingredient->amount = $request->amount;
        $ingredient->ingredient_id = $request->ingredient;
        $ingredient->save();


        return response()->json([
            "updated" => 201,
            "recipe_ingredient" => $ingredient,
        ]);
    }

    public function delete($id)
    {
        $ingredient = Recipeingredient::find($id);
        $recipe = Recipe::findOrFail($ingredient->recipe_id);
        if ($ingredient->type !== 'heading') {
            $recipe->categories()->detach($ingredient->ingredient->id);
        }
        $ingredient->delete();
        return response("Ingredient deleted.", 201);
    }

    public function updateOrder(Request $request, $recipeid)
    {
        $ingredients = Recipeingredient::where('recipe_id', $recipeid)->get();
        foreach ($ingredients as $ingredient) {
            $ingredient->timestamps = false;
            $id = $ingredient->id;
            foreach ($request->order as $ingredientorder) {
                if ($ingredientorder['id'] == $id) {
                    $ingredient->update(['order' => $ingredientorder['order']]);
                }
            }
        }
        return response('Update Successful.', 200);
    }
}
