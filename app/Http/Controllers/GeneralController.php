<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function welcome () {
        $data = \App\UserSocialmedia::find(4);
        return view('welcome', compact('data'));
    }
}
