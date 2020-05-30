<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function contact(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $email =  $request->email;
        $name =  $request->name;

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bodyMessage' => $request->message
        );

        Mail::send('emails.admin.contactform', $data, function ($message) use ($email, $name) {
            $message->to('amir@chatfata.com', 'Chatfata.com')->subject('New message from chatfata.com');
        });


        if (Mail::failures()) {
            return response()->json(
                [
                    "success" => "Something wrong please try again"
                ]
            );
        } else {
            return response()->json(
                [
                    "success" => "success"
                ]
            );
        }
    }
}
