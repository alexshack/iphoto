<?php

use Illuminate\Support\Facades\Route;

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

Route::get('structure/managers', function () {
    return view('structure.managers');
});
Route::get('structure/managers/0', function () {
    return view('structure.manager');
});
Route::get('structure/managers/add', function () {
    return view('structure.manager');
});

/* MONEY */
Route::get('money/sales-types', function () {
    return view('money.sales-types');
});
Route::get('money/incomes-types', function () {
    return view('money.incomes-types');
});
Route::get('money/expenses-types', function () {
    return view('money.expenses-types');
});

/* SALARY */
Route::get('salary/employee-statuses', function () {
    return view('salary.employee-statuses');
});
Route::get('salary/employee-positions', function () {
    return view('salary.employee-positions');
});

Route::get('salary/calcs-types', function () {
    return view('salary.calcs-types');
});
Route::get('salary/calcs-types/0', function () {
    return view('salary.calcs-type');
});
Route::get('salary/calcs-types/add', function () {
    return view('salary.calcs-type');
});

Route::get('salary/calcs', function () {
    return view('salary.calcs');
});
Route::get('salary/calcs/0', function () {
    return view('salary.calc');
});
Route::get('salary/calcs/add', function () {
    return view('salary.calc');
});

Route::get('salary/pays', function () {
    return view('salary.pays');
});
Route::get('salary/pays/0', function () {
    return view('salary.pay');
});
Route::get('salary/pays/add', function () {
    return view('salary.pay');
});