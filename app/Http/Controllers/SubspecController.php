<?php

namespace App\Http\Controllers;

use App\Models\Subspec;
use Illuminate\Http\Request;

class SubspecController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subspecs = Subspec::all();

        return view('subspec.index', compact('subspecs'));
    }
}
