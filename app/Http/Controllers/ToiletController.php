<?php

namespace App\Http\Controllers;

use App\Models\Toilet;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\String_;
use PhpParser\Node\Expr\Cast\Object_;

class ToiletController extends Controller
{
    public function show() {
        $toilets = Toilet::all();
        $washerData = Http::withToken(config('smartthings.personal_key'))->get('https://api.smartthings.com/v1/devices/676e5163-00bd-38b7-8f2e-2cae563f6a57/components/main/capabilities/washerOperatingState/status')->json();
        $washer = new \stdClass();
        $washer->state = $washerData['machineState']['value'];
        $washer->jobState = $washerData['washerJobState']['value'];
        $washer->start = Carbon::parse($washerData['machineState']['timestamp'])->setTimezone('Europe/Amsterdam');
        $washer->end = Carbon::parse($washerData['completionTime']['value'])->setTimezone('Europe/Amsterdam');
        $washer->duration = $washer->end->diffInSeconds($washer->start);
        $washer->secondsSinceStart = $washer->start->diffInSeconds(Carbon::now());
        $washer->timeLeft = Carbon::now()->diffAsCarbonInterval($washer->end);


        return view('bezet', ['toilets' => $toilets, 'washer' => $washer]);
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
