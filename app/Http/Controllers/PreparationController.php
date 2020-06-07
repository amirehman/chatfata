<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Preparation;

class PreparationController extends Controller
{
    public function store(Request $request)
    {

        $data = $request->validate([
            'step' => 'required'
        ]);
        if ($request->type) {
            $type = 'title';
        } else {
            $type = 'step';
        }

        $count = count(Preparation::where('recipe_id', $request->recipe_id)->get());

        $step = Preparation::create([
            'author_id' => auth()->user()->id,
            'step' => $request->step,
            'recipe_id' => $request->recipe_id,
            'type' => $type,
            'order' => $count,
        ]);

        return response($step, 201);
    }

    public function update(Request $request, $id)
    {
        if ($request->type) {
            $type = 'title';
        } else {
            $type = 'step';
        }
        $step = Preparation::findOrFail($id);
        $step->step = $request->step;
        $step->type = $type;
        $step->save();
        return $step;
        // return response("step updated.",201);
    }

    public function delete($id)
    {
        $step = Preparation::find($id);
        $step->delete();
        return response("step deleted.", 201);
    }

    public function updateOrder(Request $request, $recipeid)
    {
        $steps = Preparation::where('recipe_id', $recipeid)->get();
        foreach ($steps as $step) {
            $step->timestamps = false;
            $id = $step->id;
            foreach ($request->order as $steporder) {
                if ($steporder['id'] == $id) {
                    $step->update(['order' => $steporder['order']]);
                }
            }
        }
        return response('Update Successful.', 200);
    }
}
