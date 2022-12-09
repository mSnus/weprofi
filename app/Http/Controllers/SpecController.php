<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $persons = null;

        if ($request->spec_id) {
            $subspec_id = intval($request->subspec_id);
            $persons = DB::table('user_spec')
                ->select('users.title', 'users.id as user_id')
                ->join('users', 'user_id', '=', 'users.id')
                ->where('spec_id', $request->spec_id)
                ->when($subspec_id > 0, function ($q) use ($subspec_id) {
					return $q->where('subspec_id', '=', $subspec_id);
				})
                ->distinct()
                ->get();
        }

        return view('profi_list', [
            'spec_id' => $request->spec_id,
            'subspec_id' => $request->subspec_id,
            'persons' => $persons
        ]);
    }
}