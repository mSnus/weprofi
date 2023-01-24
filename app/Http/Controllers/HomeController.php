<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		 $role = Auth::user()->usertype;
			switch($role) {
				case User::typeClient:
        			return Redirect::to('/');
				case User::typeMaster:
                    // return Redirect::to('/');
					return view('profile');
				default:
					throw new \Exception("No home for usertype ".$role." exists", 1);
			}
    }
}
