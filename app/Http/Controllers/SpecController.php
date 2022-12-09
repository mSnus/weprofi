<?php

namespace App\Http\Controllers;

use App\Models\Spec;
use App\Models\Subspec;
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
        $subspecs = null;

        if ($request->spec_id) {
            $spec_id = intval($request->spec_id);
            $subspec_id = intval($request->subspec_id);
            $persons = DB::table('user_spec')
                ->select('users.title', 'users.id as user_id', 'images.path as avatar', 'userinfos.tagline')
                ->leftJoin('users', 'user_id', '=', 'users.id')
                ->leftJoin('userinfos', 'userinfos.user_id', '=', 'users.id')
                ->leftJoin('images', function ($join) {
                    $join->on('userinfos.avatar', '=', 'images.id');
                    $join->on('images.type', '=', DB::raw("1"));
                })
                ->where('spec_id', $spec_id)
                ->when($subspec_id > 0, function ($q) use ($subspec_id) {
                    return $q->where(function ($query) use ($subspec_id){
                        $query->where('subspec_id', '=', $subspec_id)->orWhere('subspec_id', '=', 0);
                    }
                    );
				})
                ->distinct()
                ->get();

            $spec = Spec::where('id', $spec_id)->firstOrFail();

            if ($subspec_id == 0) {
                $subspecs = Subspec::where('spec_id', $spec_id);
            }
        }

        return view('profi_list', [
            'spec_id' => $request->spec_id,
            'subspec_id' => $request->subspec_id,
            'spec' => $spec,
            'persons' => $persons,
            'subspecs' => $subspecs
        ]);
    }
}