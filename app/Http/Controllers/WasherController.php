<?php

namespace App\Http\Controllers;

use App\Models\Washer;
use Illuminate\Http\Request;

class WasherController extends Controller
{
    public function list() {
        $washers = Washer::all();
        return view('washers.list', ['washers' => $washers]);
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'smartthings_id' => 'required',
        ]);

        Washer::create($validated);
        return redirect()->back();
    }
    public function edit(Washer $washer) {
        return view('washers.edit', ['washer' => $washer]);
    }

    public function store(Request $request, Washer $washer) {
        $validated = $request->validate([
            'name' => 'required',
            'smartthings_id' => 'required',
        ]);

        $washer->update($validated);
        return redirect()->route('washers.list');
    }

    public function delete(Washer $washer) {
        $washer->delete();
        return redirect()->back();
    }

    public function update(Washer $washer) {
        $washer->updateState();

        return redirect()->back();
    }
}
