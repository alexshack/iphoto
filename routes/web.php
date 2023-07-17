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

Route::middleware(['web'])->group(function () {

    // Гость
    Route::middleware(['guest'])->group(function () {
        Route::group([
                         'prefix'     => 'auth',
                         'namespace'  => 'App\Http\Controllers\Auth',
                     ],
            function () {
                Route::get('/login', 'LoginController@showLoginForm')->name('auth.show_login_form');
                Route::post('/login', 'LoginController@login')->name('auth.login');
                Route::get('/forgot', 'ForgotPasswordController@showLinkRequestForm')->name('auth.forgot');
                Route::post('/forgot', 'ForgotPasswordController@sendResetLinkEmail')->name('auth.send');
                Route::get('/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
                Route::post('/reset', 'ResetPasswordController@updatePassword')->name('auth.update');
        });

    });


    // Авторизованный
    Route::middleware(['auth'])->group(function () {

        Route::group([
                         'prefix'     => 'auth',
                         'namespace'  => 'App\Http\Controllers\Auth',
                     ],
        function () {
                Route::get('/logout', 'LoginController@logout')->name('auth.logout');
        });

        Route::group([
                         'prefix'     => 'account',
                         'namespace'  => 'App\Http\Controllers\User',
                     ],
            function () {
                Route::get('/change-password', 'AccountController@changePassword')->name('account.show_change_password_form');
                Route::post('/change-password', 'AccountController@updatePassword')->name('account.update_password');
        });

        // Роль Админа
        Route::middleware(['role:admin'])->prefix('admin')->group(function() {
            Route::get('/', function () {
                return view('admin.index');
            })->name('admin.home');

            // Менеджера
            Route::get('structure/managers', 'App\Http\Controllers\Structure\ManagerController@index')->name('admin.structure.managers.index');
            Route::get('structure/managers/{id}', 'App\Http\Controllers\Structure\ManagerController@edit')->name('admin.structure.managers.edit');
            Route::post('structure/managers/{id}', 'App\Http\Controllers\Structure\ManagerController@update')->name('admin.structure.managers.update');
            Route::get('structure/manager/add', 'App\Http\Controllers\Structure\ManagerController@create')->name('admin.structure.managers.create');
            Route::post('structure/manager/add', 'App\Http\Controllers\Structure\ManagerController@store')->name('admin.structure.managers.store');
            // Сотрудники
            Route::get('structure/employees', 'App\Http\Controllers\Structure\EmployeeController@index')->name('admin.structure.employees.index');
            Route::get('structure/employees/{id}', 'App\Http\Controllers\Structure\EmployeeController@edit')->name('admin.structure.employees.edit');
            Route::post('structure/employees/{id}', 'App\Http\Controllers\Structure\EmployeeController@update')->name('admin.structure.employees.update');
            Route::get('structure/employee/add', 'App\Http\Controllers\Structure\EmployeeController@create')->name('admin.structure.employees.create');
            Route::post('structure/employee/add', 'App\Http\Controllers\Structure\EmployeeController@store')->name('admin.structure.employees.store');
            // Рекрутеры
            Route::get('structure/hrs', 'App\Http\Controllers\Structure\HrController@index')->name('admin.structure.hrs.index');
            Route::get('structure/hrs/{id}', 'App\Http\Controllers\Structure\HrController@edit')->name('admin.structure.hrs.edit');
            Route::post('structure/hrs/{id}', 'App\Http\Controllers\Structure\HrController@update')->name('admin.structure.hrs.update');
            Route::get('structure/hr/add', 'App\Http\Controllers\Structure\HrController@create')->name('admin.structure.hrs.create');
            Route::post('structure/hr/add', 'App\Http\Controllers\Structure\HrController@store')->name('admin.structure.hrs.store');

            // Виды продаж
            Route::get('money/sales-types', 'App\Http\Controllers\Money\SalesTypeController@index')->name('admin.money.sales_types.index');
            Route::post('money/sales-type/add', 'App\Http\Controllers\Money\SalesTypeController@store')->name('admin.money.sales_types.store');
            Route::post('money/sales-types/{id}', 'App\Http\Controllers\Money\SalesTypeController@update')->name('admin.money.sales_types.update');
            // Виды поступлений
            Route::get('money/incomes-types', 'App\Http\Controllers\Money\IncomesTypeController@index')->name('admin.money.incomes_types.index');
            Route::post('money/incomes-type/add', 'App\Http\Controllers\Money\IncomesTypeController@store')->name('admin.money.incomes_types.store');
            Route::post('money/incomes-types/{id}', 'App\Http\Controllers\Money\IncomesTypeController@update')->name('admin.money.incomes_types.update');
            // Виды расходов
            Route::get('money/expenses-types', 'App\Http\Controllers\Money\ExpensesTypeController@index')->name('admin.money.expenses_types.index');
            Route::post('money/expenses-type/add', 'App\Http\Controllers\Money\ExpensesTypeController@store')->name('admin.money.expenses_types.store');
            Route::post('money/expenses-types/{id}', 'App\Http\Controllers\Money\ExpensesTypeController@update')->name('admin.money.expenses_types.update');

            /*Route::get('structure/managers/0', function () {
                return view('structure.manager');
            });*/
//            Route::get('structure/managers/add', function () {
//                return view('structure.manager');
//            });

        });

        Route::get('/', function () {
            return view('admin.index');
        })->name('home');


        /* AUTH */
        Route::get('login', function () {

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
//        Route::get('admin', function () {
//            return view('admin.index');
//        });
        /* MONEY */
        Route::get('money/days', function () {
            return view('money.days');
        });
        Route::get('money/days/0', function () {
            return view('money.day');
        });

        Route::get('money/sales-types', function () {
            return view('money.sales-types');
        });

        Route::get('money/incomes', function () {
            return view('money.incomes');
        });
        Route::get('money/incomes/0', function () {
            return view('money.income');
        });
        Route::get('money/incomes/add', function () {
            return view('money.income');
        });
        Route::get('money/incomes-types', function () {
            return view('money.incomes-types');
        });

        Route::get('money/expenses', function () {
            return view('money.expenses');
        });
        Route::get('money/expenses/0', function () {
            return view('money.expense');
        });
        Route::get('money/expenses/add', function () {
            return view('money.expense');
        });
        Route::get('money/expenses-types', function () {
            return view('money.expenses-types');
        });

        Route::get('money/moves', function () {
            return view('money.moves');
        });
        Route::get('money/moves/0', function () {
            return view('money.move');
        });
        Route::get('money/moves/add', function () {
            return view('money.move');
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

        /* GOODS */
        Route::get('goods', function () {
            return view('goods.goods');
        });
        Route::get('goods/add', function () {
            return view('goods.good');
        });
        Route::get('goods/0', function () {
            return view('goods.good');
        });

    });
});
