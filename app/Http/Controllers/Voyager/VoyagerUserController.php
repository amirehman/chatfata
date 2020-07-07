<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Http\Request;

use TCG\Voyager\Http\Controllers\VoyagerUserController as BaseVoyagerUserController;

class VoyagerUserController extends BaseVoyagerUserController
{
    public function store(Request $request, $id) {
        return $id;
    }
}
