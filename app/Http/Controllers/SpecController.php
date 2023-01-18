<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Macroregion;
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

        $region_id = trim($request->region_id);

        if ($spec_id > 0) {
            $persons = DB::table('users')
                ->select('users.name', 'users.rating', 'users.id as user_id', 'images.path as avatar', 'users.tagline')
                ->leftJoin('user_spec', 'user_spec.user_id', '=', 'users.id')
                ->leftJoin('images', function ($join) {
                    $join->on('images.parent_id', '=', 'users.id');
                    $join->on('images.type', '=', DB::raw("1"));
                })
                ->where('user_spec.spec_id', $spec_id)
                ->when($subspec_id > 0, function ($q) use ($subspec_id) {
                    return $q->where(
                        function ($query) use ($subspec_id) {
                                $query->where('user_spec.subspec_id', '=', $subspec_id)->orWhere('user_spec.subspec_id', '=', 0);
                            }
                    );
                })
                ->when($region_id != '', function ($q) use ($region_id) {
                    $isMacroRegion = substr($region_id, 0, 1) == '_';


                    return ($isMacroRegion) 
                     ? $q->whereRaw('users.region like \'%'.$region_id.'%\'') //->whereRaw('OR users.macroregion like \'%'.$region_id.'%\'')
                     : $q->whereRaw('users.region like \'%'.$region_id.'%\'');
				})
                ->where('users.status', 'active')
                ->orderBy(DB::raw('RAND()'))
                ->distinct()
                ->get();

            $spec = Spec::where('id', $spec_id)->firstOrFail();

            if ($subspec_id == 0) {
                $subspecs = Subspec::where('spec_id', $spec_id);
            }
        }

        $region_options = array_merge(
            City::getOptions($request->region_id ?? ''),
            []
            // Macroregion::getOptions($request->region_id ?? '_israel'),
        );

        return view('pages.profi_list', [
            'spec_id' => $spec_id,
            'subspec_id' => $subspec_id,
            'region_id' => $request->region_id ?? '',
            'spec' => $spec,
            'persons' => $persons,
            'subspecs' => $subspecs,
            'region_options' =>  $region_options,
        ]);
    }

    public static function getPath($spec_id = null, $subspec_id = null, $region_id = null) {
        $path = '/';

        $path .= ($spec_id) ? intval($spec_id).'/' : '';
        $path .= ($subspec_id) ? intval($subspec_id).'/' : '0/';
        $path .= ($region_id) ? intval($region_id).'/' : '';

        return $path;
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