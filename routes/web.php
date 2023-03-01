<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserControler;
use App\Http\Controllers\ManageTicketController;
use App\Http\Controllers\AssignedTicketController;
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
Route::get('/student_dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student')->middleware('role:student');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//departments
Route::get('department-datatable', [DepartmentController::class, 'index']);
Route::post('store-department', [DepartmentController::class, 'store']);
Route::post('edit-department', [DepartmentController::class, 'edit']);
Route::post('delete-department', [DepartmentController::class, 'destroy']);

//ticket
Route::get('ticket-datatable', [TicketController::class, 'index']);
Route::get('myticket-datatable', [TicketController::class, 'myTicket']);
Route::post('store-ticket', [TicketController::class, 'store']);
Route::post('edit-ticket', [TicketController::class, 'edit']);
Route::post('delete-ticket', [TicketController::class, 'destroy']);

//user
Route::get('user-datatable', [UserControler::class, 'index']);
Route::post('store-user', [UserControler::class, 'store']);
Route::post('edit-user', [UserControler::class, 'edit']);
Route::post('delete-user', [UserControler::class, 'destroy']);

//manageticket
Route::get('manageticket-datatable', [ManageTicketController::class, 'index']);
Route::post('store-manageticket', [ManageTicketController::class, 'store']);
Route::post('edit-manageticket', [ManageTicketController::class, 'edit']);
Route::post('delete-manageticket', [ManageTicketController::class, 'destroy']);

//assignedticket
Route::get('assignedticket-datatable', [AssignedTicketController::class, 'index']);
Route::post('store-assignedticket', [AssignedTicketController::class, 'store']);
Route::post('edit-assignedticket', [AssignedTicketController::class, 'edit']);
Route::post('delete-assignedticket', [AssignedTicketController::class, 'destroy']);

//profile
Route::middleware(['auth'])->group(function () {
    Route::get('profile', [ProfileController::class,'getProfile'])->name('profile');
    Route::post('profile', [ProfileController::class,'postProfileUpdate'])->name('updateProfile');
});






