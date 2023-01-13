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

    $terms = preg_replace('~[0-9\\\/;_\'\"]~', '', $request->term);

    $arrTerms = explode(' ', $terms);
    $arrTerms = array_slice(array_filter($arrTerms), 0, 3);

    $parsedSearchTerm = join(' ', $arrTerms);
    
    if (count($arrTerms) > 0) {

      $searchStrings = [];
      for ($i = 0; $i < count($arrTerms); $i++) {
        $term = trim(mb_strtolower($arrTerms[$i]));
        $searchStrings[] = '(users.content LIKE \'%'.$term.'%\''.
        ' OR users.tagline LIKE \'%'.$term.'%\''. 
        ' OR users.pricelist LIKE \'%'.$term.'%\')';
      }

      $searchString = join(' OR ', $searchStrings);

      $persons = DB::table('users')
          ->select('users.name', 'users.rating', 'users.id as user_id', 'images.path as avatar', 'users.content' ,
          'users.tagline')
          ->leftJoin('images', function ($join) {
              $join->on('images.parent_id', '=', 'users.id');
              $join->on('images.type', '=', DB::raw("1"));
          })
          ->where('users.status', 'active')
          ->whereRaw($searchString)
          ->distinct()
          ->limit(50)
          ->get();
    }

        $count = count($persons);

    return view('pages.search', [
        'term' => $parsedSearchTerm,
        'persons' => $persons,
        'count' => $count,
        'result' => $count > 0 ? 'Результаты поиска ('.$count.')' : 'Ничего не найдено (<i>'.$term.'</i>)'
    ]);
  }

}

?>