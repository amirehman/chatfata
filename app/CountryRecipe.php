<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryRecipe extends Model
{
    protected $fillable = [
        'recipe_id', 'country_id', 'state_id'
    ];
}
