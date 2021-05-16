<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Offer;

use App\Http\Controllers\ClientController;

class OfferController extends Controller
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
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
	//TODO:check if logged in
	$client = Client::updateOrCreate([
		'phone' => $request->phone,
		'email' => $request->email,
		'name' => $request->name,
	]);
	// $client->phone = $request->phone;
	// $client->email = $request->email;
	// $client->name = $request->name;
	// $client->save();
	$newClientId = $client->id;

	$offer = new Offer;
	$offer->title = $request->title;
	$offer->descr = $request->descr;
	$offer->client = $newClientId;
	$offer->status = Offer::statusPending;
	//TODO:add location
	$offer->save();

	return redirect('/')->with('status', 'Заявка отправлена!');

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