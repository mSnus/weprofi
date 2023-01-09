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

        $spec_id = intval($request->spec_id);
        $subspec_id = intval($request->subspec_id);

        if ($spec_id > 0) {
            $persons = DB::table('users')
                ->select('users.name', 'users.rating', 'users.id as user_id', 'images.path as avatar', 'users.tagline')
                ->leftJoin('images', function ($join) {
                    $join->on('images.parent_id', '=', 'users.id');
                    $join->on('images.type', '=', DB::raw("1"));
                })
                ->where('spec_id', $spec_id)
                ->where('users.status', 'active')
                ->when($subspec_id > 0, function ($q) use ($subspec_id) {
                    return $q->where(function ($query) use ($subspec_id){
                        $query->where('subspec_id', '=', $subspec_id)->orWhere('subspec_id', '=', 0);
                    }
                    );
				})
                // ->orderBy('spec.ordering', 'ASC')
                ->distinct()
                ->get();

            $spec = Spec::where('id', $spec_id)->firstOrFail();

            if ($subspec_id == 0) {
                $subspecs = Subspec::where('spec_id', $spec_id);
            }
        }

        return view('profi_list', [
            'spec_id' => $spec_id,
            'subspec_id' => $subspec_id,
            'spec' => $spec,
            'persons' => $persons,
            'subspecs' => $subspecs
        ]);
    }

    public function getSpecList(Request $request)
    {
        $specs = Spec::get(); 
        return $specs->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function getSubspecList(Request $request)
    {
        $subspecs = Subspec::get(); 
        return $subspecs->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}