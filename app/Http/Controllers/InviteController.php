<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    //
    public function processLink(Request $request) {
        $user = User::where('id', $request->user_id)->firstOrFail();

        if ($user->invite_token != ''  && $request->token == $user->invite_token) {
            Auth::loginUsingId($user->id);
            // $user->invite_token = '';
            $user->save();
            return redirect('/profile')->with('status', 'Добро пожаловать! Сейчас необходимо задать и сохранить пароль, иначе вы не сможете войти в систему');
        } else {
            return abort(500,'Неправильный код приглашения');
        }
    }
}
