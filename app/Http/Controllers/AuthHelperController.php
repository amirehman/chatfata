<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthHelperController extends Controller
{
    public function isEmailValid($email)
    {

        $user = User::where('email', '=', $email)->pluck('email');
        $unique_id = $this->generateUsername();

        if ($user->count() == 0) {
            return response()->json([
                "user" => false,
                "username" => $unique_id
            ]);
        } else {
            return response()->json([
                "user" => true,
                "username" => $unique_id

            ]);
        }
    }
    private function generateUsername () {
        $id = base_convert(microtime(false), 10, 36);
        $username = User::where('username', '=', $id)->pluck('username');
        if ($username->count() == 0) {
            return $id;
        }else{
            $this->generateUsername();
        }
    }
    public function isUsernameValid($username)
    {

        $user = User::where('email', '=', $email)->pluck('email');
        if ($user->count() == 0) {
            return response()->json([
                "user" => false
            ]);
        } else {
            return response()->json([
                "user" => true
            ]);
        }
    }
}
