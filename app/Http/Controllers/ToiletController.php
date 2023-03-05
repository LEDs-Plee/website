<?php

namespace App\Http\Controllers;

use App\Models\Toilet;
use App\Models\User;
use App\Models\Visit;
use App\Models\Washer;
use App\Notifications\ToiletNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\String_;
use PhpParser\Node\Expr\Cast\Object_;

class ToiletController extends Controller
{
    public function list() {
        $toilets = Toilet::all();
        return view('toilets.list', ['toilets' => $toilets]);
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        Toilet::create($validated);
        return redirect()->back();
    }
    public function edit(Toilet $toilet) {
        return view('toilets.edit', ['toilet' => $toilet]);
    }

    public function store(Request $request, Toilet $toilet) {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        $toilet->update($validated);
        return redirect()->route('toilets.list');
    }

    public function delete(Toilet $toilet) {
        $toilet->delete();
        return redirect()->back();
    }

    public function regenerate(Toilet $toilet) {
        $toilet->generateSecret();
        $toilet->save();

        return redirect()->back();
    }

    public function api(Toilet $toilet, $secret, $status) {
        if ($toilet->secret != $secret) return Response::json('invalid secret', 403);
        if ($toilet->free != $status) {

            $toilet->free = $status;
            $toilet->save();

            if($status == true) {
                $visit = $toilet->visits()->where('end', null)->latest()->firstOrFail();
                $visit->end = Carbon::now();
                $visit->save();
                $notification = new ToiletNotification($toilet);
                $users = User::where('notify_toilet', true)->get();
                Notification::send($users, $notification);
                foreach ($users as $user) {
                    $user->notify_toilet = false;
                    $user->save();
                }
            } else {
                $toilet->visits()->create([
                    'start' => Carbon::now(),
                ])->save();
            }

        }
        return Response::json('success', 200);
    }
}
