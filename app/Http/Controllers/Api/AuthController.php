<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends BaseController
{
    public const TOKEN_NAME = 'token-all-scope';

    public static function removeOldTokens(int $uID): int
    {
        try {
            return (int)\DB::table('oauth_access_tokens')->where('user_id', $uID)->delete();
        } catch (\Throwable $e) {
            Log::channel('access_token')->error('Ошибка удаления токенов из бд', [
                'uid' => $uID,
                'class' => static::class,
                'msg' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTrace(),
            ]);

            return 0;
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);
        $input['role'] = 'user';
        $user = User::create($input);

        $data = $this->prepareToken($user);

        return $this->sendResponse(__('auth.success_register'), $data);
    }

    public function login(LoginRequest $request): JsonResponse
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

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->token();
        if (!$token) {
            return $this->sendResponse(__('auth.logout_success'));
        }

        $token->revoke();

        return $this->sendResponse(__('auth.logout_success'));
    }

    private function prepareToken(User $user): array
    {
        self::removeOldTokens($user->id);

        return [
            self::TOKEN_PARAM => $user->createToken(self::TOKEN_NAME)->accessToken,
            'name' => $user->name,
            'uid' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
        ];
    }
}
