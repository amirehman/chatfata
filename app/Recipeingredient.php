<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipeingredient extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'amount', 'note', 'type', 'ingredient_id', 'recipe_id', 'order', 'author_id'
    ];

    public function recipe () {
        return $this->belongsTo(Recipe::class);
    }

    public function ingredient () {
        return $this->belongsTo(Ingredient::class);
    }

}
