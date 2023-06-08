<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboard;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', function () {
    return view('auth.login');
});

/* AUTH */
Route::get('login', function () {
    return view('auth.login');
});
Route::get('forgot', function () {
    return view('auth.forgot');
});
Route::get('reset', function () {
    return view('auth.reset');
});
Route::get('change-password', function () {
    return view('auth.change');
});
Route::get('lock', function () {
    return view('auth.lock');
});

/* ADMIN */
Route::get('admin', function () {
    return view('admin.index');
});


/* STRUCTURE */
Route::get('structure/employees', function () {
    return view('structure.employees');
});
Route::get('structure/employees/0', function () {
    return view('structure.employee');
});
Route::get('structure/employees/add', function () {
    return view('structure.employee');
});