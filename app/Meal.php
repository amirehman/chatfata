<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    public function recipes () {
        return $this->belongsToMany(Recipe::class);
    }
}
