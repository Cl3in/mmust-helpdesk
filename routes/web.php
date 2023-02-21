<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();
Route::get('/admin_dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin')->middleware('role:admin');
Route::get('/technician_dashboard', [App\Http\Controllers\Technician\DashboardController::class, 'index'])->name('technician')->middleware('role:technician');
Route::get('/student_dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student')->middleware('role:student');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

