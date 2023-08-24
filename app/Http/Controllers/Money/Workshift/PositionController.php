<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\EmployeePositionRepositoryInterface;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    private EmployeePositionRepositoryInterface $positionRepository;

    public function __construct(EmployeePositionRepositoryInterface $positionRepository) {
        $this->positionRepository = $positionRepository;
    }

    public function index() {
        $positions = $this->positionRepository->getActive();
        return response()->json($positions);
    }
}
