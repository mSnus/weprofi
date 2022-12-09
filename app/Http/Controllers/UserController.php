<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = null;
        $gallery = null;
        $skills = null;
        $skills_list = "";        

        if ($request->user_id) {
            $user_id = intval($request->user_id);
            $user = DB::table('users')
                ->select('users.title', 'users.id as user_id', 'images.path as avatar', 'users.created_at', 
                        'userinfos.tagline', 'userinfos.content', 'userinfos.pricelist', 'userinfos.rating')
                ->leftJoin('userinfos', 'userinfos.user_id', '=', 'users.id')
                ->leftJoin('images', function($join) {
                             $join->on('userinfos.avatar', '=', 'images.id');
                             $join->on('images.type', '=', DB::raw("1"));
                         })
                ->where('users.id', $user_id)
                ->first();

            $user->content = nl2br($user->content);
            
            $pricelist = array_filter(preg_split('~[\r\n]~', $user->pricelist));

            foreach ($pricelist as $key => $line) {
                $pricelist[$key] = preg_replace(
                    '~^(.*)\.{4}(\d+)\s?sh([^\r\n\t]*)$~Uims', 
                    '<div class="price-block">
                        <div class="price-text">$1</div>
                        <div class="price-value">$2&#8362 <span class="price-extra">$3</span></div>                        
                    </div>', 
                    $pricelist[$key]);                
            }


            $user->pricelist = join("\n", $pricelist);

            $user->join_date = date("d-m-Y", strtotime($user->created_at));

            $gallery = DB::table('users')
                ->select('users.id as user_id', 'images.path as src')
                ->leftJoin('images', function($join) {
                             $join->on('images.parent_id', '=', 'users.id');
                             $join->on('images.type', '=', DB::raw("2"));
                         })
                ->where('users.id', $user_id)
                ->get();

            $skills = DB::table('users')
                ->select('users.id as user_id', 'specs.title as spec_title', 'subspecs.title as subspec_title')
                ->leftJoin('user_spec', function($join) {
                             $join->on('user_spec.user_id', '=', 'users.id');
                         })
                ->leftJoin('specs', function($join) {
                            $join->on('user_spec.spec_id', '=', 'specs.id');
                        })
                ->leftJoin('subspecs', function($join) {
                            $join->on('user_spec.subspec_id', '=', 'subspecs.id');
                        })                        
                ->where('users.id', $user_id)
                ->get();    
            
            foreach ($skills as $skill) {
                $skills_list .= $skill->spec_title . ($skill->subspec_title ? ' ('.$skill->subspec_title.')' : '').', ';
            }

            $skills_list = mb_substr($skills_list, 0, mb_strlen($skills_list) - 2);
        }

        return view('user_page', [
            'user_id' => $user_id,
            'user' => $user,
            'gallery' => $gallery,
            'skills' => $skills_list
        ]);
    }
}