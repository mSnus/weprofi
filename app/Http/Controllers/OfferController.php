<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Offer;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Telegram\Bot\Laravel\Facades\Telegram;


class OfferController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
	return view('offers');
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
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {

	if (Auth::check()) {
		/**
		 * Получаем имеющиеся данные о пользователе
		 */
		$user = Auth::user();
	} else {
		/**
		 * Регистрируем нового пользователя и добавляем дополнительные поля в таблицу клиентов
		 */
		$phone = $request->name;
		$phone = preg_replace("~[^0-9\+]~", "", $phone);
		if (substr($phone, 0, 1) == "8") $phone = "+7".substr($phone,1); // 8925xxxx => +7925xxxx
		if (substr($phone, 0, 1) == "9") $phone = "+7".$phone; // 925xxxx => +7925xxxx

		$request->name =  $phone;
		$request->validate([
			'name' => 'required|string|max:255|unique:users|regex:~[\+0-9]{7,15}~',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => ['required', 'confirmed', Rules\Password::min(6)],
		]);

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'usertype' => User::typeClient,
		]);

		event(new Registered($user));

		Auth::login($user);

		$client = new Client;
		$client->status = Client::statusRegistered;
		$client->title = $request->fullname;
		$client->userid = $user->id;
		$client->save();

		// $response = Telegram::sendMessage([
		// 	'chat_id' => 'CHAT_ID',
		// 	'text' => 'Hello World'
		//  ]);

		//  $messageId = $response->getMessageId();
	}

	// return redirect(RouteServiceProvider::HOME);


	$offer = new Offer;
	$offer->title = $request->title;
	$offer->descr = $request->descr;
	$offer->location = $request->location;
	$offer->client = $user->id;
	$offer->status = Offer::statusPending;

	$offer->save();

	return redirect('/home')->with('status', 'Заявка отправлена!'.' ('.$offer->id.')');

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

/**
   * Update offer
   *
   * @return Response
   */
  public function update(Request $request, $id)
  {
	$offer = Offer::find($id);
	$offer->title = $request->title;
	$offer->descr = $request->descr;
	$offer->location = $request->location;
	$offer->update();

	return redirect('/home')->with('status', 'Заявка обновлена.');

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

}
