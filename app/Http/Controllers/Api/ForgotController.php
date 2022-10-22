<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class ForgotController extends BaseController
{
    /**
     * Сброс и установка нового пароля.
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $input = $request->validated();
        $newToken = '';
        $response = Password::reset($input, function (User $user, $password) use (&$newToken) {
            $user->password = bcrypt($password);

            if ($user->save() && AuthController::removeOldTokens($user->id)) {
                $newToken = $user->createToken(AuthController::TOKEN_NAME)->accessToken;
            }
        });

        $isError = $response !== Password::PASSWORD_RESET;
        if ($isError) {
            return $this->sendError(__('auth.pass_not_reset'), [], self::BAD_REQUEST_CODE);
        }

        if (!$newToken) {
            return $this->sendResponse(__('auth.pass_reset_no_token'), [
                self::REDIRECT_PARAM => 'login',
            ]);
        }

        return $this->sendResponse(__('auth.pass_reset'), [self::TOKEN_PARAM => $newToken]);
    }

    /**
     * Отсылаем ссылку на восстановления пароля.
     * @param ForgotRequest $request
     * @return JsonResponse
     */
    public function forgot(ForgotRequest $request): JsonResponse
    {
        $response = Password::sendResetLink($request->validated());

        $isError = $response !== Password::RESET_LINK_SENT;
        if ($isError) {
            return $this->sendError(__('auth.pass_reset_link_not_send'), [], self::BAD_REQUEST_CODE);
        }

        return $this->sendResponse(__('auth.pass_reset_link_send'));
    }
}
