<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\EmployeeStatusRepositoryInterface;
use Illuminate\Http\Request;


class EmployeeStatusController extends Controller
{
    public EmployeeStatusRepositoryInterface $employeeStatusRepository;

    public function __construct(EmployeeStatusRepositoryInterface $employeeStatusRepository) {
        $this->employeeStatusRepository = $employeeStatusRepository;
    }

    public function index() {
        $statuses = $this->employeeStatusRepository->getAll();
        return response()->json($statuses);
    }
}
