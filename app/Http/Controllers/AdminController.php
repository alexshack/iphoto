<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private WorkShiftRepositoryInterface $workShiftRepository;

    public function __construct(WorkShiftRepositoryInterface $workShiftRepository) {
        $this->workShiftRepository = $workShiftRepository;
    }

    public function index() {
        $todayWorkShifts = $this->workShiftRepository->getToday();
        $yesterdayWorkShifts = $this->workShiftRepository->getYesterday();
        return view('admin.index', compact('todayWorkShifts', 'yesterdayWorkShifts'));
    }
}
