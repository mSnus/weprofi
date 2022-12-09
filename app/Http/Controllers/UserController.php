<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user_id) {
            $user_id = intval($request->user_id);
            $user = DB::table('users')
                ->select('users.title', 'users.id as user_id')
                ->join('users_info', 'user_id', '=', 'users_info.id')
                ->where('user.id', $user_id)
                ->get();
        }

        return view('user_page', [
            'user_id' => $user_id,
            'user' => $user
        ]);
    }
}