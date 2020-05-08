<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function categories () {
        return $this->belongsToMany(Ingredient::class);
    }

    public function meals () {
        return $this->belongsToMany(Meal::class);
    }

    public function author () {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function steps () {
        return $this->hasMany(Preparation::class);
    }

    public function ingredients () {
        return $this->hasMany(Recipeingredient::class, 'recipe_id');
    }

    public function notes () {
        return $this->hasMany(Recipeingredientnote::class, 'recipe_id');
    }

}
