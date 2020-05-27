<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{

    protected $fillable = [
        'user_id', 'title', 'slug', 'body', 'difficulty', 'prep_time', 'video', 'image'
    ];

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

    public function images () {
        return $this->hasMany(Media::class, 'recipe_id');
    }

    public function collection($type) {
        return $this->images()->where('collection', '=', $type);
    }

}
