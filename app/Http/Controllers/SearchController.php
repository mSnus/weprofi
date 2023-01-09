<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\Client;

class SearchController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function search(Request $request)
  {
    $persons = null;

    $term = preg_replace('~[0-9\\\/;_\'\"]~', '', $request->term);

    if ($term) {
        $persons = DB::table('users')
            ->select('users.name', 'users.rating', 'users.id as user_id', 'images.path as avatar', 'users.content' ,
            'users.tagline')
            ->leftJoin('images', function ($join) {
                $join->on('images.parent_id', '=', 'users.id');
                $join->on('images.type', '=', DB::raw("1"));
            })
            ->where('users.status', 'active')
            ->whereRaw('users.content LIKE \'%'.mb_strtolower($term).'%\'  
                        OR users.tagline LIKE \'%'.mb_strtolower($term).'%\' 
                        OR users.pricelist LIKE \'%'.mb_strtolower($term).'%\' ')
            ->distinct()
            ->get();
    }

        $count = count($persons);

    return view('search', [
        'term' => $term,
        'persons' => $persons,
        'count' => $count,
        'result' => $count > 0 ? 'Результаты поиска ('.$count.')' : 'Ничего не найдено (<i>'.$term.'</i>)'
    ]);
  }

}

?>