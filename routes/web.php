<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserControler;
use App\Http\Controllers\ManageTicketController;
use App\Http\Controllers\AssignedTicketController;
use App\Http\Controllers\RespondTicketController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();
Route::get('/admin_dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin')->middleware('role:admin');
Route::get('/technician_dashboard', [App\Http\Controllers\Technician\DashboardController::class, 'index'])->name('technician')->middleware('role:technician');
Route::get('/staff_dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('staff')->middleware('role:staff');
Route::get('/student_dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student')->middleware('role:student');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//departments
Route::get('department-datatable', [DepartmentController::class, 'index']);
Route::post('store-department', [DepartmentController::class, 'store']);
Route::post('edit-department', [DepartmentController::class, 'edit']);
Route::post('delete-department', [DepartmentController::class, 'destroy']);

//ticket
Route::get('ticket-datatable', [TicketController::class, 'index']);
Route::post('store-ticket', [TicketController::class, 'store']);
Route::get('ticket/{id}', [TicketController::class, 'show'])->name('tickets.show');
Route::post('edit-ticket', [TicketController::class, 'edit']);
Route::post('delete-ticket', [TicketController::class, 'destroy']);
Route::get('myticket-datatable', [TicketController::class, 'myTicket']);
Route::get('mypendingticket-datatable', [TicketController::class, 'myPendingTicket']);
Route::get('myclosedticket-datatable', [TicketController::class, 'myClosedTicket']);


//user
Route::get('user-datatable', [UserControler::class, 'index']);
Route::post('store-user', [UserControler::class, 'store']);
Route::post('edit-user', [UserControler::class, 'edit']);
Route::post('delete-user', [UserControler::class, 'destroy']);


// student
Route::get('student-datatable', [UserControler::class, 'getStudent']);
Route::post('store-student', [UserControler::class, 'storeStudent']);
Route::post('edit-student', [UserControler::class, 'editStudent']);
Route::post('delete-student', [UserControler::class, 'destroyStudent']);

//manageticket
Route::get('manageticket-datatable', [ManageTicketController::class, 'index']);
Route::post('store-manageticket', [ManageTicketController::class, 'store']);
Route::post('edit-manageticket', [ManageTicketController::class, 'edit']);
Route::post('delete-manageticket', [ManageTicketController::class, 'destroy']);
Route::get('adminpendingticket-datatable', [ManageTicketController::class, 'adminPendingTicket']);
Route::get('adminclosedticket-datatable', [ManageTicketController::class, 'adminClosedTicket']);
Route::get('technicianpendingticket-datatable', [ManageTicketController::class, 'technicianPendingTicket']);
Route::get('technicianclosedticket-datatable', [ManageTicketController::class, 'technicianClosedTicket']);

//assignedticket
Route::get('assignedticket-datatable', [AssignedTicketController::class, 'index']);
Route::post('store-assignedticket', [AssignedTicketController::class, 'store']);
Route::post('edit-assignedticket', [AssignedTicketController::class, 'edit']);
Route::post('delete-assignedticket', [AssignedTicketController::class, 'destroy']);
Route::get('allassignedticket-datatable', [AssignedTicketController::class, 'allAssigned']);

//respondticket
Route::get('respondticket-datatable', [RespondTicketController::class, 'index']);
Route::post('store-respondticket', [RespondTicketController::class, 'store']);
Route::post('edit-respondticket', [RespondTicketController::class, 'edit']);


//profile
Route::middleware(['auth'])->group(function () {
    Route::get('profile', [ProfileController::class,'getProfile'])->name('profile');
    Route::post('profile', [ProfileController::class,'postProfileUpdate'])->name('updateProfile');
});






