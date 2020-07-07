<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'country_recipes');
    }

}
