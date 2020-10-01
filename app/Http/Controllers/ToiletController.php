<?php

namespace App\Http\Controllers;

use App\Models\ToiletStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\String_;

class ToiletController extends Controller
{
    public function show() {
        $toilets = ToiletStatus::all();
        return view('bezet', ['toilets' => $toilets]);
    }

    public function store(ToiletStatus $toilet, $secret, $status) {
        if ($toilet->secret != $secret) return Response::json('invalid secret', 403);
        if ($toilet->free != $status) {
            $toilet->free = $status;
            $toilet->save();
        }
        return Response::json('success', 200);
    }
}
