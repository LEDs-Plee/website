<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function notifyWasher(): RedirectResponse
    {
        $user = auth()->user();
        $user->notify_washer = !$user->notify_washer;
        $user->save();
        return redirect()->back();
    }

    public function notifyToilet(): RedirectResponse
    {
        $user = auth()->user();
        $user->notify_toilet = !$user->notify_toilet;
        $user->save();
        return redirect()->back();
    }
}
