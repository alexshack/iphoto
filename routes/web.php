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
            Route::get('/', 'App\Http\Controllers\AdminController@index')->name('admin.home');

            /**
             * Структура
             */
            // Города
            Route::get('structure/cities', 'App\Http\Controllers\Structure\CityController@index')->name('admin.structure.cities.index');
            Route::get('structure/cities/{id}', 'App\Http\Controllers\Structure\CityController@edit')->name('admin.structure.cities.edit');
            Route::post('structure/cities/{id}', 'App\Http\Controllers\Structure\CityController@update')->name('admin.structure.cities.update');
            Route::get('structure/city/add', 'App\Http\Controllers\Structure\CityController@create')->name('admin.structure.cities.create');
            Route::post('structure/city/add', 'App\Http\Controllers\Structure\CityController@store')->name('admin.structure.cities.store');
            Route::post('structure/city-manager/add', 'App\Http\Controllers\Structure\CityManagerController@store')->name('admin.structure.city_manager.store');
            Route::delete('structure/city-managers/{id}/delete', 'App\Http\Controllers\Structure\CityManagerController@destroy')->name('admin.structure.city_manager.destroy');
            Route::post('structure/city-managers/{id}', 'App\Http\Controllers\Structure\CityManagerController@update')->name('admin.structure.city_manager.update');
            // Точки
            Route::get('structure/place', 'App\Http\Controllers\Structure\PlaceController@index')->name('admin.structure.places.index');
            Route::get('structure/place/add', 'App\Http\Controllers\Structure\PlaceController@create')->name('admin.structure.places.create');
            Route::post('structure/place/add', 'App\Http\Controllers\Structure\PlaceController@store')->name('admin.structure.places.store');
            Route::get('structure/places/{id}', 'App\Http\Controllers\Structure\PlaceController@edit')->name('admin.structure.places.edit');
            Route::post('structure/places/{id}', 'App\Http\Controllers\Structure\PlaceController@update')->name('admin.structure.places.update');
            Route::post('structure/place-calc/add', 'App\Http\Controllers\Structure\PlaceCalcController@store')->name('admin.structure.place_calcs.store');
            Route::post('structure/place-calcs/{id}', 'App\Http\Controllers\Structure\PlaceCalcController@update')->name('admin.structure.place_calcs.update');
            Route::post('structure/place-calcs/{id}/delete', 'App\Http\Controllers\Structure\PlaceCalcController@destroy')->name('admin.structure.place_calcs.destroy');
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

            /**
             * Финансовый учет
             */
            // Поступление ДС
            Route::get('money/incomes', 'App\Http\Controllers\Money\IncomeController@index')->name('admin.money.incomes.index');
            Route::get('money/incomes/{id}', 'App\Http\Controllers\Money\IncomeController@edit')->name('admin.money.incomes.edit');
            Route::delete('money/incomes/{id}/delete', 'App\Http\Controllers\Money\IncomeController@destroy')->name('admin.money.incomes.destroy');
            Route::get('money/income/add', 'App\Http\Controllers\Money\IncomeController@create')->name('admin.money.incomes.create');
            // Расходы ДС

            // Перемещение ДС

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

            /**
             * Учет зарплаты
             */
            // Статусы сотрудников
            Route::get('salary/data-item/{id}', 'App\Http\Controllers\Structure\ManagerController@userSalaryData')->name('admin.salary.data-item');
            Route::get('salary/employee-status', 'App\Http\Controllers\Salary\EmployeeStatusController@index')->name('admin.salary.employee_statuses.index');
            Route::post('salary/employee-status/add', 'App\Http\Controllers\Salary\EmployeeStatusController@store')->name('admin.salary.employee_statuses.store');
            Route::post('salary/employee-statuses/{id}', 'App\Http\Controllers\Salary\EmployeeStatusController@update')->name('admin.salary.employee_statuses.update');
            // Должности сотрудников
            Route::get('salary/employee-position', 'App\Http\Controllers\Salary\EmployeePositionController@index')->name('admin.salary.employee_positions.index');
            Route::post('salary/employee-position/add', 'App\Http\Controllers\Salary\EmployeePositionController@store')->name('admin.salary.employee_positions.store');
            Route::post('salary/employee-positions/{id}', 'App\Http\Controllers\Salary\EmployeePositionController@update')->name('admin.salary.employee_positions.update');
            // Виды начислений
            Route::get('salary/calc-type', 'App\Http\Controllers\Salary\CalcsTypeController@index')->name('admin.salary.calc_type.index');
            Route::get('salary/calc-type/add', 'App\Http\Controllers\Salary\CalcsTypeController@create')->name('admin.salary.calc_type.create');
            Route::post('salary/calc-type/add', 'App\Http\Controllers\Salary\CalcsTypeController@store')->name('admin.salary.calc_type.store');
            Route::get('salary/calc-types/{id}', 'App\Http\Controllers\Salary\CalcsTypeController@edit')->name('admin.salary.calc_type.edit');
            Route::post('salary/calc-types/{id}', 'App\Http\Controllers\Salary\CalcsTypeController@update')->name('admin.salary.calc_type.update');

            /**
             * Товарный учет
             */
            // Товары
            Route::get('goods', 'App\Http\Controllers\Goods\GoodsController@index')->name('admin.goods.index');
            Route::get('goods/{id}', 'App\Http\Controllers\Goods\GoodsController@edit')->name('admin.goods.edit');
            Route::post('goods/{id}', 'App\Http\Controllers\Goods\GoodsController@update')->name('admin.goods.update');
            Route::get('good/add', 'App\Http\Controllers\Goods\GoodsController@create')->name('admin.goods.create');
            Route::post('good/add', 'App\Http\Controllers\Goods\GoodsController@store')->name('admin.goods.store');
            Route::get('goods/category/all', 'App\Http\Controllers\Goods\GoodsCategoryController@index')->name('admin.goods.categories.index');
            Route::get('goods/category/create', 'App\Http\Controllers\Goods\GoodsCategoryController@create')->name('admin.goods.categories.create');
            Route::post('goods/category/add', 'App\Http\Controllers\Goods\GoodsCategoryController@store')->name('admin.goods.categories.store');
            Route::get('goods/category/{id}/edit', 'App\Http\Controllers\Goods\GoodsCategoryController@edit')->name('admin.goods.categories.edit');
        });

        Route::get('/', 'App\Http\Controllers\AdminController@index')->name('home');

        Route::get('test', function () {
            return view('structure.employee');
        });


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

        Route::get('structure/cities', function () {
            return view('structure.cities');
        });
        Route::get('structure/cities/0', function () {
            return view('structure.city');
        });
        Route::get('structure/cities/add', function () {
            return view('structure.city');
        });
        Route::get('structure/cities/dashboard/0', function () {
            return view('structure.city-dashboard');
        });
        //Route::get('structure/places', function () {
            //return view('structure.places');
        //});
        Route::get('structure/places/0', function () {
            return view('structure.place');
        });
        Route::get('structure/places/add', function () {
            return view('structure.place');
        });
        Route::get('structure/places/dashboard/0', function () {
            return view('structure.place-dashboard');
        });

        /* MONEY */
        Route::get('money/days', 'App\Http\Controllers\Money\WorkShiftController@index')->name('money.days');
        Route::get('money/days/{id}', 'App\Http\Controllers\Money\WorkShiftController@edit')->name('money.days.edit');
        Route::put('money/days/{id}', 'App\Http\Controllers\Money\WorkShiftController@update')->name('money.days.update');

        Route::group([
            'prefix' => 'workshift',
            'as' => 'workshift.',
            'namespace' => "App\Http\Controllers\Money\Workshift"
        ], function () {
            Route::resource('calc', 'CalcsController');
            Route::post('close', 'WorkShiftController@close')->name('close');
            Route::post('reopen', 'WorkShiftController@reopen')->name('reopen');
            Route::post('preview', 'WorkShiftController@previewPayrolls')->name('preview');
            Route::resource('employee', 'WorkshiftEmployeeController');
            Route::get('employee-status', 'EmployeeStatusController@index')->name('employee.status');
            Route::get('employee-position', 'PositionController@index')->name('employee.position');
            Route::get('sales-types-list', 'SalesController@getSalesTypes')->name('salesTypes');
            Route::resource('goods', 'SalesController');
            Route::get('users/active-managers', 'UsersController@getActiveManagers')->name('users.active_managers');
            Route::get('users/city/{cityID}', 'UsersController@getByCity')->name('users.city');
            Route::get('ping', 'WithdrawController@ping')->name('ping');
            Route::resource('withdraw', 'WithdrawController');
            Route::get('expense-types', 'ExpenseController@types')->name('expenseTypes');
            Route::resource('expense', 'ExpenseController');
            Route::resource('move', 'MovesController');
            Route::resource('pay', 'PaysController');
            Route::resource('fcd', 'FCDController');
            Route::get('goods-list', 'GoodsController@index')->name('goods_list');
            Route::get('places', 'PlacesController@getByWorkShiftCity')->name('places_list');

            Route::group(['prefix' => 'file', 'as' => 'file.'], function () {
                Route::post('upload', 'UploadController@upload')->name('upload');
                Route::delete('destory/{fileName}', 'UploadController@destroy')->name('destroy');
            });
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

        Route::get('money/expenses', 'App\Http\Controllers\Money\ExpensesController@index')->name('admin.money.expenses.index');
        Route::get('money/expenses/add', 'App\Http\Controllers\Money\ExpensesController@create')->name('admin.money.expenses.create');
        Route::get('money/expenses/{id}', 'App\Http\Controllers\Money\ExpensesController@edit')->name('admin.money.expenses.edit');

        Route::get('money/expenses-types', function () {
            return view('money.expenses-types');
        });

        Route::get('money/moves', 'App\Http\Controllers\Money\MovesController@index')->name('admin.money.moves.index');
        Route::get('money/moves/add', 'App\Http\Controllers\Money\MovesController@create')->name('admin.money.moves.create');
        Route::get('money/moves/{id}', 'App\Http\Controllers\Money\MovesController@edit')->name('admin.money.moves.edit');

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

        Route::get('salary/calcs', 'App\Http\Controllers\Salary\CalcsController@index')->name('admin.salary.calc.index');
        Route::get('salary/calcs/add', 'App\Http\Controllers\Salary\CalcsController@create')->name('admin.salary.calc.create');
        Route::get('salary/calcs/{id}', 'App\Http\Controllers\Salary\CalcsController@edit')->name('admin.salary.calc.edit');

        Route::get('salary/pays', 'App\Http\Controllers\Salary\PayController@index')->name('admin.salary.pay.index');
        Route::get('salary/pays/add', 'App\Http\Controllers\Salary\PayController@create')->name('admin.salary.pay.create');
        Route::get('salary/pays/{id}', 'App\Http\Controllers\Salary\PayController@edit')->name('admin.salary.pay.edit');

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
