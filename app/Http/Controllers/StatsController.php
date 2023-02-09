<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function updateViews(Request $request) {
        $stats = \App\Models\UserViews::firstOrNew(['source_id' => $request->source_id, 'target_id' => $request->target_id]);
        $stats->view_count = $stats->view_count + 1;
        $stats->save();
    }
}
