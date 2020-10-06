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
}
