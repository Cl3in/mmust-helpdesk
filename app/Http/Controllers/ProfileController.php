<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\ManageTicket;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = Auth::user();
        $unassignedtickets = Ticket::where('status', 0)->count();
        $user = Auth::user();
        $technicianpendingtickets = ManageTicket::where('technician_id', $user->id)->where('status', 0)->count();

        return view('profile.profile', compact('user','unassignedtickets','technicianpendingtickets'));
    }

    public function postProfileUpdate(Request $request)
    {
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);

        Auth::user()->update($request->all());
        return back()->with(['message'=>'Successfully updated']);
    }
}
