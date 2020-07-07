<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ChannelApplication extends Model
{

    protected $fillable = [
        'user_id', 'status', 'channel_type', 'channel_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
