<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Redirect;

class ContactsController extends Controller
{
    public function send(Request $request) {
        $request->validate([
            'phone' => 'required|string|min:9',
            'email' => 'required|string|email',
            'message' => 'required|string|min:10',
        ]);


        $to      = 'support@weprofi.co.il';
        $subject = "WeProfi: {$request->user} ".($request->user_id ? "(#{$request->user_id})" : '')." ({$request->phone})";
        $message = $request->message;
        $headers = 'From: WeProfi <'.($request->email ?? 'support@weprofi.co.il').'>' . "\r\n" .
            'Reply-To: '.($request->email ?? 'support@weprofi.co.il') . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        return Redirect::to('/contact')->with('status', 'Ваше сообщение отправлено!');
    }
}
