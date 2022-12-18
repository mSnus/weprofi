<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityStoreRequest;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cities = City::all();

        return view('city.index', compact('posts'));
    }

    /**
     * @param \App\Http\Requests\CityStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityStoreRequest $request)
    {
        $city = City::create($request->all());
    }
}
