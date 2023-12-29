<?php

namespace App\View\Components\Dashboard;

use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftGoodsRepositoryInterface;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GeneralStatistic extends Component
{
    public $citiesCount;
    public $employeesCount;
    public $placesCount;
    public $salesTotalMonth;
    public $salesTotalToday;
    public $salesTotalYesterday;

    private CityRepositoryInterface $cityRepository;
    private PlaceRepositoryInterface $placeRepository;
    private UserRepositoryInterface $userRepository;
    private WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository;

    /**
     * Create a new component instance.
     */
    public function __construct(
        CityRepositoryInterface $cityRepository,
        PlaceRepositoryInterface $placeRepository,
        UserRepositoryInterface $userRepository,
        WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository
    )
    {
        $this->cityRepository = $cityRepository;
        $this->placeRepository = $placeRepository;
        $this->userRepository = $userRepository;
        $this->workShiftGoodsRepository = $workShiftGoodsRepository;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->citiesCount = $this->cityRepository->getCount();
        $this->employeesCount = $this->userRepository->getCountByRoleSlug('employee');
        $this->placesCount = $this->placeRepository->getCount();
        $today = Carbon::now();
        $this->salesTotalToday = $this->workShiftGoodsRepository->getSalesToDateSum($today);
        $this->salesTotalYesterday = $this->workShiftGoodsRepository->getSalesToDateSum($today->subDay());
        $this->salesTotalMonth = $this->workShiftGoodsRepository->getSalesToMonth($today->month);
        return view('components.dashboard.general-statistic');
    }
}
