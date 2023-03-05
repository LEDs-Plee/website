<?php

namespace App\Http\Controllers;

use App\Models\Toilet;
use App\Models\Washer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): Renderable
    {
        $toilets = Toilet::all();
        $washers = Washer::all();

        if(auth()->check() && auth()->user()->approved_at) {
            return view('bezet', ['toilets' => $toilets, 'washers' => $washers]);
        }
        return view('home');
    }
}
