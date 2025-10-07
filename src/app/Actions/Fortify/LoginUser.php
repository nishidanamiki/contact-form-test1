<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginRequest;

class LoginUser
{
    /**
     * Fortify のカスタムログイン処理
     */
    public function authenticate(array $input)
    {
        //  LoginRequest のルールを使ってバリデーション
        $loginRequest = new LoginRequest();
        $validator = Validator::make($input, $loginRequest->rules(), $loginRequest->messages());
        $validator->validate();

        // メールアドレスでユーザー検索
        $user = User::where('email', $input['email'])->first();

        // ユーザーが存在しない場合
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'このメールアドレスは登録されていません',
            ]);
        }

        // パスワードが一致しない場合
        if (!Auth::attempt([
            'email' => $input['email'],
            'password' => $input['password'],
        ], $input['remember'] ?? false)) {
            throw ValidationException::withMessages([
                'password' => 'パスワードが正しくありません',
            ]);
        }

        // セッション再生成（セキュリティ対策）
        session()->regenerate();
    }
}
