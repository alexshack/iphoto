<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getByCity(Request $request, $cityID) {
        $users = $this->userRepository->getByCity($cityID);
        return response()->json($users);
    }
}
