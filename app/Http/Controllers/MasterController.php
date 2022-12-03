<?php

namespace App\Http\Controllers;



use App\Models\Master;

use App\Models\User;
use App\Models\Offer;
use App\Models\OfferToMaster;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Telegram\Bot\Laravel\Facades\Telegram;

class MasterController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('masters');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('auth.register');
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
			'name' => $phone,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'usertype' => User::typeMaster,
		]);

		event(new Registered($user));

		Auth::login($user);

		$master = new Master;
		$master->title = $request->title;
		$master->status = Master::statusRegistered;
		$master->userid = $user->id;
		$master->save();


		$user->update(['linked_id' => $master->id]);

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
		return view('masters');
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

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
			$master =  Master::find($id);
			$user = User::find($master->userid);

			if ($master->userid != Auth::user()->user_role->userid) {
				return redirect('profile')->with('error', 'Профиль не сохранён, ошибка авторизации.');
			}

			$user->linked_id = $master->userid;
			$user->name = $request->name;
			$user->email= $request->email;
			$user->update();


			$master->title = $request->title;
			$master->location = $request->location;
			$master->descr = $request->descr ?? '';
			$master->update();

			return redirect('profile')->with('status', 'Профиль сохранён');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	}

	/**
	 * Отправляет отклик на выбранную заявку
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function takeOffer($offer_id)
	{
			$o2m = new \App\Models\OfferToMaster;
			$o2m->storeSuggestion($offer_id);

			$offer = \App\Models\Offer::find($offer_id);
			$client = \App\Models\User::find($offer->client);

			if ($client->telegram_id) {
				$response = Telegram::sendMessage([
					'chat_id' => $client->telegram_id,
					'text' => 'На вашу заявку поступил новый отклик! https://pochinim.online/home'
				]);
			}

			return redirect('home')->with('status', 'Ваше предложение отправлено!');
	}

}
