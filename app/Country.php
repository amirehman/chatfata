<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'country_recipes');
    }
}
