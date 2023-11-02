<?php

namespace App\Providers;

use App\Models\City;
use App\Repositories\CalcsRepository;
use App\Repositories\CalcsTypeRepository;
use App\Repositories\CityManagerRepository;
use App\Repositories\CityRepository;
use App\Repositories\EmployeePositionRepository;
use App\Repositories\EmployeeStatusRepository;
use App\Repositories\ExpensesTypeRepository;
use App\Repositories\ExpensesRepository;
use App\Repositories\GoodsCategoryRepository;
use App\Repositories\GoodsRepository;
use App\Repositories\IncomeRepository;
use App\Repositories\IncomesTypeRepository;
use App\Repositories\Interfaces\CalcsRepositoryInterface;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use App\Repositories\Interfaces\CityManagerRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\EmployeePositionRepositoryInterface;
use App\Repositories\Interfaces\EmployeeStatusRepositoryInterface;
use App\Repositories\Interfaces\ExpensesRepositoryInterface;
use App\Repositories\Interfaces\ExpensesTypeRepositoryInterface;
use App\Repositories\Interfaces\GoodsCategoryRepositoryInterface;
use App\Repositories\Interfaces\GoodsRepositoryInterface;
use App\Repositories\Interfaces\IncomeRepositoryInterface;
use App\Repositories\Interfaces\IncomesTypeRepositoryInterface;
use App\Repositories\Interfaces\MovesRepositoryInterface;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use App\Repositories\Interfaces\PlaceCalcRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Repositories\Interfaces\SalesTypeRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftEmployeeRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftFinalCashDeskRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftGoodsRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftPayrollRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftWithdrawalRepositoryInterface;
use App\Repositories\MovesRepository;
use App\Repositories\PaysRepository;
use App\Repositories\PlaceCalcRepository;
use App\Repositories\PlaceRepository;
use App\Repositories\SalesTypeRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkShiftRepository;
use App\Repositories\WorkShiftEmployeeRepository;
use App\Repositories\WorkShiftGoodsRepository;
use App\Repositories\WorkShiftWithdrawalRepository;
use App\Repositories\WorkShiftPayrollRepository;
use App\Repositories\WorkShiftFinalCashDeskRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SalesTypeRepositoryInterface::class, SalesTypeRepository::class);
        $this->app->bind(IncomesTypeRepositoryInterface::class, IncomesTypeRepository::class);
        $this->app->bind(ExpensesTypeRepositoryInterface::class, ExpensesTypeRepository::class);
        $this->app->bind(ExpensesRepositoryInterface::class, ExpensesRepository::class);
        $this->app->bind(EmployeeStatusRepositoryInterface::class, EmployeeStatusRepository::class);
        $this->app->bind(EmployeePositionRepositoryInterface::class, EmployeePositionRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(CityManagerRepositoryInterface::class, CityManagerRepository::class);
        $this->app->bind(CalcsTypeRepositoryInterface::class, CalcsTypeRepository::class);
        $this->app->bind(PlaceRepositoryInterface::class, PlaceRepository::class);
        $this->app->bind(PlaceCalcRepositoryInterface::class, PlaceCalcRepository ::class);
        $this->app->bind(GoodsRepositoryInterface::class, GoodsRepository ::class);
        $this->app->bind(GoodsCategoryRepositoryInterface::class, GoodsCategoryRepository ::class);
        $this->app->bind(IncomeRepositoryInterface::class, IncomeRepository ::class);
        $this->app->bind(MovesRepositoryInterface::class, MovesRepository::class);
        $this->app->bind(CalcsRepositoryInterface::class, CalcsRepository::class);
        $this->app->bind(PaysRepositoryInterface::class, PaysRepository::class);
        $this->app->bind(WorkShiftRepositoryInterface::class, WorkShiftRepository::class);
        $this->app->bind(WorkShiftEmployeeRepositoryInterface::class, WorkShiftEmployeeRepository::class);
        $this->app->bind(WorkShiftFinalCashDeskRepositoryInterface::class, WorkShiftFinalCashDeskRepository::class);
        $this->app->bind(WorkShiftWithdrawalRepositoryInterface::class, WorkShiftWithdrawalRepository::class);
        $this->app->bind(WorkShiftGoodsRepositoryInterface::class, WorkShiftGoodsRepository::class);
        $this->app->bind(WorkShiftPayrollRepositoryInterface::class, WorkShiftPayrollRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $menuCities = City::all();
        View::share('menuCities', $menuCities);
    }
}
