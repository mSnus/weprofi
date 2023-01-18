<?php

namespace App\Http\Controllers;

use App\Models\City;
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
  private function prepareTerms($strTerms)
  {
    $terms = preg_replace('~[0-9\\\/;_\'\"]~', '', $strTerms);

    //разбиваем по пробелу и берём только 3 первых, которые длиннее 3 символов
    $arrTerms = explode(' ', $terms);
    $arrTerms = array_slice(array_filter($arrTerms, function ($el) {
      return mb_strlen($el) > 2; }), 0, 3);

    return $arrTerms;
  }
  private function buildSearchString($arrTerms, $arrSearchFields)
  {
    $searchString = '';

    $searchFields = [];

    for ($i = 0; $i < count($arrTerms); $i++) {
      $term = trim(mb_strtolower($arrTerms[$i]));

      $fields = [];
      for ($k = 0; $k < count($arrSearchFields); $k++) {
        $fields[] = $arrSearchFields[$k] . ' LIKE \'%' . $term . '%\'';
      }

      // между полями - ИЛИ
      $searchFields[] = '(' . join(' OR ', $fields) . ')';
    }

    // между терминами - И
    $searchString = join(' OR ', $searchFields);

    return $searchString;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function search(Request $request)
  {

    $persons = null;
    $specs = null;

    $arrTerms = $this->prepareTerms($request->term);
    $parsedSearchTerm = join(' ', $arrTerms);

    if (count($arrTerms) > 0) {

      $searchPersons = $this->buildSearchString($arrTerms, ['users.content', 'users.tagline', 'users.pricelist']);

      $persons = DB::table('users')
        ->select(
          'users.name',
          'users.rating',
          'users.id as user_id',
          'images.path as avatar',
          'users.content',
          'users.tagline'
        )
        ->leftJoin('images', function ($join) {
          $join->on('images.parent_id', '=', 'users.id');
          $join->on('images.type', '=', DB::raw("1"));
        })
        ->where('users.status', 'active')
        ->whereRaw($searchPersons)
        ->distinct()
        ->limit(50)
        ->get();

      $searchSpecs = $this->buildSearchString($arrTerms, ['specs.title', 'subspecs.title', 'specs.synonims', 'subspecs.synonims']);

      $specs = DB::table('specs')
        ->select('specs.id', 'specs.title', 
        'subspecs.id as subspec_id', 'subspecs.title as subspec_title', )
        ->leftJoin('subspecs', function ($join) {
          $join->on('subspecs.spec_id', '=', 'specs.id');
        })
        ->whereRaw($searchSpecs)
        ->distinct()
        ->orderBy(DB::raw('RAND()'))
        ->limit(50)
        ->get();
    }

    $count = (is_array($persons)) ? count($persons) : 0;
    $count_specs = (is_array($specs)) ? count($specs) : 0;

    $cities = City::get()->all();
    $region_options = ['Израиль'];

    return view('pages.search', [
      'term' => $parsedSearchTerm,
      'persons' => $persons,
      'specs' => $specs,
      'count' => $count,
      'count_specs' => $count_specs,
      'result' => 'Результаты поиска',
      // 'region_options' => $region_options,
    ]);
  }

}

?>