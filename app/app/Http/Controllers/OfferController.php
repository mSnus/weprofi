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


	$request->validate([
		'name' => 'required|string|max:255|unique:users',
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

	// return redirect(RouteServiceProvider::HOME);

	//TODO:check if logged in

	$offer = new Offer;
	$offer->title = $request->title;
	$offer->descr = $request->descrshort." ".$request->descr;
	$offer->location = $request->location;
	$offer->client = $client->userid;
	$offer->status = Offer::statusPending;

	$offer->save();

	return redirect('/')->with('status', 'Заявка отправлена!'.' ('.$offer->id.')');

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
  public function update($id)
  {

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

?>