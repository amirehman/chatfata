<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\ChannelApplication;

class UserController extends Controller
{
    public function applyForChannel (Request $request) {

        $request->validate([
            'user_id' => 'required',
            'status' => 'required',
            'type' => 'required',
            'url' => 'required',
        ]);

        ChannelApplication::create([
            'user_id' => $request->user_id,
            'channel_type' => $request->type,
            'channel_url' => $request->url,
            'status' => $request->status,
        ]);

        return response("Request submited successfully! ", 201);

    }
}
