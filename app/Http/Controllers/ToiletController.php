<?php

namespace App\Http\Controllers;

use App\Models\Toilet;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\String_;

class ToiletController extends Controller
{
    public function show() {
        $toilets = Toilet::all();
        return view('bezet', ['toilets' => $toilets]);
    }

    public function store(Toilet $toilet, $secret, $status) {
        if ($toilet->secret != $secret) return Response::json('invalid secret', 403);
        if ($toilet->free != $status) {

            $toilet->free = $status;
            $toilet->save();

            if($status == true) {
                $visit = $toilet->visits()->where('end', null)->latest()->firstOrFail();
                $visit->end = Carbon::now();
                $visit->save();
            } else {
                $toilet->visits()->create([
                    'start' => Carbon::now(),
                ])->save();
            }

        }
        return Response::json('success', 200);
    }
}
