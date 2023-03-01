<?php

namespace App\Http\Controllers\Admin;

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
        $pendingtickets = ManageTicket::where('status', 0)->count();
        $completedtickets = ManageTicket::where('status', 1)->count();
        $users = User::all()->count();
        $departments = Department::all()->count();
        return view('admin.dashboard', compact('pendingtickets',
         'completedtickets', 'users', 'departments'));      }
}
