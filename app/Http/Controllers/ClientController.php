<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\Client;

class ClientController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

  }

/**
	 * Handle an incoming registration request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$phone = $request->name;
		$phone = preg_replace("~[^0-9\+]~", "", $phone);
		if (substr($phone, 0, 1) == "8") $phone = "+7".substr($phone,1); // 8925xxxx => +7925xxxx
		if (substr($phone, 0, 1) == "9") $phone = "+7".$phone; // 925xxxx => +7925xxxx

		$request->validate([
			'name' => 'required|string|max:255|unique:users',
			// 'email' => 'required|string|email|max:255|unique:users',
			// 'password' => ['sometimes','required', 'confirmed', Rules\Password::min(6)],
		]);

		$user = User::create([
			'name' => $request->name,
			'email' => $phone,
			'password' => Hash::make($request->password),
			'usertype' => User::typeClient,
		]);

		event(new Registered($user));

		Auth::login($user);

		$client = new Client();
		$client->title = $request->title;
		$client->status = Client::statusRegistered;
		$client->userid = $user->id;
		$client->save();


		$user->update(['linked_id' => $client->id]);

		return redirect(RouteServiceProvider::HOME);
	}

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {

  }


}

?>