<?php

namespace App\Http\Controllers\Structure;

use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\UserSalaryDataRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    private UserRepositoryInterface $userRepository;
    private UserSalaryDataRepositoryInterface $userSalaryDataRepository;

    private $text = [
        'title' => 'Менеджеры',
        'count' => 'Всего менеджеров',
        'count_new' => 'Новые менеджеры',
        'list_title' => 'Список менеджеров',
        'add_button' => 'Добавить менеджера',
        'role_column' => 'Менеджер',
        'role' => 'managers'
    ];

    public function __construct(UserRepositoryInterface $userRepository,
        UserSalaryDataRepositoryInterface $userSalaryDataRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userSalaryDataRepository = $userSalaryDataRepository;
    }

    public function index()
    {
        $list = $this->userRepository->getByRoleSlug('manager');
        $counts = [
            'all' => count($list),
            'male' => $this->userRepository->getMaleCountByRoleSlug('manager'),
            'female' => $this->userRepository->getFemaleCountByRoleSlug('manager'),
        ];
        return view('structure.managers')->with(['text' => $this->text, 'list' => $list, 'counts' => $counts]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('structure.manager')
            ->with([
                'text' => $this->text,
                'user' => $user,
                'personal' => $user->getPersonalData(),
                'work' => $user->getWorkData()
            ]);
    }

    public function update(UpdateUserRequest $request)
    {
        try {
            $data = $request->validated();
            $user_id = $request->route('id');
            $user = User::findOrFail($user_id);
            $photo = null;
            if($request->hasFile('user.photo')) {
                $photo = $request->file('user.photo');
            }
            $user->updateUser($data, $photo);
            return back()->with('message', 'Данные изменены!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        return view('structure.manager', ['text' => $this->text, 'role_id' => 3]);
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $data = $request->validated();
            $user = new User();
            $user->{ UserContract::FIELD_EMAIL } = $data['user'][UserContract::FIELD_EMAIL];
            $user->{ UserContract::FIELD_PASSWORD } = Hash::make($data['user'][UserContract::FIELD_PASSWORD]);
            $user->{ UserContract::FIELD_ROLE_ID } = $data['user'][UserContract::FIELD_ROLE_ID];
            if($request->hasFile('user.photo')) {
                $photo = $request->file('user.photo');
                $user->{ UserContract::FIELD_PHOTO } = $user->uploadPhoto($photo);
            }
            $user->save();
            $user->getPersonalData()->update($data['personal']);
            $user->getWorkData()->update($data['work']);
            return redirect()->to(route('admin.structure.managers.edit', ['id' => $user->{ UserContract::FIELD_ID }]))->with('message', 'Менеджер добавлен!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function userSalaryData(Request $request, $salaryDataID)
    {
        $salaryData = $this->userSalaryDataRepository->getSalaryItem($salaryDataID);
        return view('salary.user-data-item', compact('salaryData'));
    }
}
