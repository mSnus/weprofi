<?php

namespace App\Http\Controllers;

use App\Models\UserStats;
use Illuminate\Http\Request;
use App\Models\SimpleUtm;

class StatsController extends Controller
{
    public function index(){
      $utmStats = SimpleUtm::all();
      $userStats = UserStats::select('users.id', 'users.name', 'users.phone', 'user_stats.own_profile_visits')
      ->leftJoin('users', 'user_id', '=', 'users.id')
      ->whereNotNull('phone')
      ->orderBy('phone')
      ->get();

      return view('admin.stats')->with('utmStats', $utmStats)->with('userStats', $userStats);
    }
    public function updateViews(Request $request) {
        $stats = \App\Models\UserViews::firstOrNew(['source_id' => $request->source_id, 'target_id' => $request->target_id]);
        $stats->view_count = $stats->view_count + 1;
        $stats->save();
    }

    public static function updateSimpleUtm() {
        $utm_source = \Request::query('utm_source');
        if (isset($utm_source)) {
            $stats = \App\Models\SimpleUtm::firstOrNew(['source_id' => $utm_source, 'target_id' => \Request::getRequestUri()]);
            $stats->visit_count = $stats->visit_count + 1;
            $stats->save();
        }
    }
}
