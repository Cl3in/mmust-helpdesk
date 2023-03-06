<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
      }
      public function index() {
        $user = Auth::user();
        $pendingtickets = Ticket::where('user_id', $user->id)->where('status', 0)->count();
        $completedtickets = Ticket::where('user_id', $user->id)->where('status', 1)->count();
        return view('staff.dashboard', compact('pendingtickets', 'completedtickets'));
      }
}
