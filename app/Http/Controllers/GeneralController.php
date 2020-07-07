<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function welcome () {
        $data = \App\User::find(1);
        // return view('welcome', compact('data'));
        return view('emails.users.channel_approved');
    }
}
