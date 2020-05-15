<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Socialmedia extends Model
{
    public function usersocialmedia () {
        return $this->belongsTo(UserSocialmedia::class);
    }
}
