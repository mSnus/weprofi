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
			'email' => 'required|string|email|max:255|unique:users',
			'password' => ['sometimes','required', 'confirmed', Rules\Password::min(6)],
		]);

		$user = User::create([
			'name' => $phone,
			'email' => $request->email,
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

/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
			$client =  Client::find($id);
			$user = User::find($client->userid);

			if ($client->userid != Auth::user()->user_role->userid) {
				return redirect('profile')->with('error', 'Профиль не сохранён, ошибка авторизации.');
			}

			$user->linked_id = $client->id;
			$user->name = $request->name;
			$user->email= $request->email;
			$user->update();


			$client->title = $request->title;
			$client->update();

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
	 * Принимает отклик на выбранную заявку
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function acceptOffer($offer_id, $master_id)
	{
			$offer = new \App\Models\Offer;
			$offer->storeAcception($offer_id, $master_id);

			$offer = \App\Models\Offer::find($offer_id);
			$user = \App\Models\User::find($master_id);

			$client = \App\Models\User::find($offer->client);

			if ($user->telegram_id) {
				$response = Telegram::sendMessage([
					'chat_id' => $user->telegram_id,
					'text' => 'Уважаемый <b>'.$user->title().'</b>! Ваша заявка одобрена клиентом '.
					($client->telegram_id ? '@'.$client->telegram_id : '')
					.'. Напишите ему сообщение или позвоните по телефону <a href="tel:'.$client->name.'">'.$client->name.'</a> и обсудите все детали.',
					'parse_mode' => 'HTML',
				]);
			}

			return redirect('home')->with('status', 'Ваш ответ отправлен мастеру! Ожидайте его звонка с номера '.$user->name);
	}

	public function editOffer($offer_id)
	{
		return view('edit-offer',['offer_id' => $offer_id]);
	}

	/**
	 * Редактирует выбранную заявку
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateOffer($offer_id)
	{
			$offer = \App\Models\Offer::find($offer_id);

			$client = Auth::user();



			return redirect('home')->with('status', 'Заявка сохранена.');
	}
}

?>