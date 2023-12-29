<?php

namespace App\Http\Controllers\User;

use App\Contracts\UserContract;
use App\Http\Controllers\AuthController;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AccountController extends AuthController
{


    public function changePassword()
    {
        return view('auth.change');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if(!Hash::check($request->current_password, Auth::user()->{ UserContract::FIELD_PASSWORD })) {
            return back()->withErrors([
                'current_password' => 'Неверный пароль!'
            ]);
        }

        try {
            Auth::user()->update([ UserContract::FIELD_PASSWORD => Hash::make($request->password) ]);
            return redirect()->to(route('auth.logout'));
        } catch (\Exception $e) {
            return back()->withErrors([
                'current_password' => 'Ошибка базы данных!'
            ]);
        }
    }
}
