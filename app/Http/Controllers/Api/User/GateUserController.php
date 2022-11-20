<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\JsonResponse;

class GateUserController extends BaseController
{
    /**
     * User info with actions
     * @param int|null $id
     * @return JsonResponse
     */
    public function info(?int $id = 0): JsonResponse
    {
        $id = (int)$id;
        $resp = app(InfoUserController::class)->info($id);
        if ($resp->getStatusCode() !== self::OK_CODE) {
            return $resp;
        }

        $userInfo = $resp->getData()->data;

        return $this->sendResponse("", [
            'user' => $userInfo
        ]);
    }
}
