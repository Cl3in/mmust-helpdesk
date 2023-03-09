<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManageTicket;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Department;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
      }
      public function index() {
        $user = Auth::user();
        $pendingtickets = ManageTicket::where('technician_id', $user->id)->where('status', 0)->count();
        $completedtickets = ManageTicket::where('technician_id', $user->id)->where('status', 1)->count();
        $students = User::where('role', 'student')->count();
        $departments = Department::all()->count();
        $technicianpendingtickets = ManageTicket::where('technician_id', $user->id)->where('status', 0)->count();
        return view('technician.dashboard', compact('pendingtickets',
         'completedtickets', 'students', 'departments','technicianpendingtickets'));
      }
}
