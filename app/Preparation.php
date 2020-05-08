<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preparation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'step', 'recipe_id', 'author_id', 'order'
    ];

    public function recipe () {
        return $this->belongsTo(Recipe::class);
    }
}
