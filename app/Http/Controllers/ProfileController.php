<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = Auth::user();
        return view('profile.profile', compact('user'));
    }

    public function postProfileUpdate(Request $request)
    {
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);

        Auth::user()->update($request->all());
        return back()->with(['message'=>'Successfully updated']);
    }
}
