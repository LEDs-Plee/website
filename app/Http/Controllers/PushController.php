<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushController extends Controller
{
    public function subscribe(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'endpoint' => 'required',
            'public_key' => 'required',
            'auth_token' => 'required',
            'encoding' => 'required'
        ]);
        $user = Auth::user();
        $user->updatePushSubscription(
            $validated['endpoint'],
            $validated['public_key'],
            $validated['auth_token'],
            $validated['encoding']
        );

        return response()->json(['message' => 'success']);
    }

    public function unsubscribe(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'endpoint' => 'required'
        ]);

        $user = Auth::user();

        $user->deletePushSubscription($validated['endpoint']);

        return response()->json(['message' => 'success']);
    }
}
