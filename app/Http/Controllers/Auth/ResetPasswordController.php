<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{

    public function showResetForm($token)
    {
        return view('auth.reset', ['token' => $token]);
    }

    public function updatePassword(ResetPasswordRequest $request)
    {
        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                        'token' => $request->token
                    ])
            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        try {
            $user = User::where(UserContract::FIELD_EMAIL, $updatePassword->email)
                ->update([UserContract::FIELD_PASSWORD => Hash::make($request->password)]);

            DB::table('password_reset_tokens')->where(['email'=> $updatePassword->email])->delete();

            return redirect(route('auth.login'))->with('message', 'Ваш пароль изменен!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Ошибка базы данных!'
            ]);
        }

    }
}
