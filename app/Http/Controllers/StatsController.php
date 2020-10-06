<?php

namespace App\Http\Controllers;

use App\Models\Toilet;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function overview() {
        $toilets = Toilet::all();

        return view('stats.overview', ['toilets' => $toilets]);
    }

    public function download() {
        return response()->json(Toilet::select('id', 'name')->with('visits:id,toilet_id,start,end')->get())->header('Content-Disposition', 'attachment; filename="toiletStats.json"');
    }
}
