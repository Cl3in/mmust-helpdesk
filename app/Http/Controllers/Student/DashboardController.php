<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
      }
      public function index() {
        $user = Auth::user();
        $pendingtickets = Ticket::where('student_id', $user->id)->where('status', 0)->count();
        $completedtickets = Ticket::where('student_id', $user->id)->where('status', 1)->count();
        return view('student.dashboard', compact('pendingtickets', 'completedtickets'));
      }
}
