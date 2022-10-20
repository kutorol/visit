<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    private const TOKEN_NAME = 'MyApp';

    public function register(RegisterRequest $request)
    {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $data = $this->prepareToken($user);

        return $this->sendResponse(__('auth.success_register'), $data);
    }

    public function login(LoginRequest $request)
    {
        $creds = ['email' => $request->get('email'), 'password' => $request->get('password')];

        if (!Auth::attempt($creds)) {
            return $this->sendError(__('auth.fail_login'), [
                'errs' => [__('auth.failed')],
            ], self::FORBIDDEN_CODE);
        }

        $data = $this->prepareToken(Auth::user());

        return $this->sendResponse(__('auth.success_login'), $data);
    }

    private function prepareToken(User $user): array
    {
        return [
            'token' => $user->createToken(self::TOKEN_NAME)->accessToken,
            'name' => $user->name,
        ];
    }
}
