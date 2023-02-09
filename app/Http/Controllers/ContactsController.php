<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Redirect;

class ContactsController extends Controller
{
    public function send(Request $request) {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
        ]);


        $to      = 'support@weprofi.co.il';
        $subject = "WeProfi: {$request->user} ({$request->phone})";
        $message = $request->message;
        $headers = 'From: WeProfi <support@weprofi.co.il>' . "\r\n" .
            'Reply-To: support@weprofi.co.il' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        return Redirect::to('/contact')->with('status', 'Ваше сообщение отправлено!');
    }
}
