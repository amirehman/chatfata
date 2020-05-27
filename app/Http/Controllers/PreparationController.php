<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use \App\Preparation;

class PreparationController extends Controller
{
    public function store(Request $request) {

        $data = $request->validate([
            'step' => 'required'
        ]);

        $step = Preparation::create([
            'author_id' => auth()->user()->id,
            'step' => $request->step,
            'recipe_id' => $request->recipe_id
        ]);

        return response($step, 201);

    }

    public function update (Request $request, $id) {
        $step = Preparation::findOrFail($id);
        $step->step = $request->step;
        $step->save();
        return response("step updated.",201);
    }

    public function delete ($id) {
        $step = Preparation::find($id);
        $step->delete();
        return response("step deleted.",201);
    }
}
