<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(): View {
        $unapprovedUsers = User::where('approved_at', null)->wherenot('email_verified_at', null)->get();
        return view('approval.index', ['unapprovedUsers' => $unapprovedUsers]);
    }

    public function approve(User $user): RedirectResponse
    {
        $user->approve();
        return redirect()->back();
    }
    public function unapproved(): View {
        return view('approval.unapproved');
    }
}
