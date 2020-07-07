<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserSocialmedia extends Model
{
    protected $fillable = [
        'status', 'socialmedia_id', 'link', 'user_id',
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }
    public function media () {
        return $this->belongsTo(Socialmedia::class, 'socialmedia_id');
    }
}
