<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public const FORBIDDEN_CODE = 403;
    public const BAD_REQUEST_CODE = 400;
    public const INTERNAL_ERROR_CODE = 500;
    public const NOT_FOUND_CODE = 404;
    public const OK_CODE = 200;

    public const REDIRECT_PARAM = 'redirect';
    public const TOKEN_PARAM = 'token';

    public static function errorResponse(string $msg, array $data = [], int $code = 0): array
    {
        return [
            'status' => FALSE,
            'msg' => $msg,
            'data' => $data,
            'code' => $code,
        ];
    }

    public function sendResponse(string $msg, array $data = []): JsonResponse
    {
        $response = [
            'status' => TRUE,
            'msg' => $msg,
            'data' => $data,
        ];

        return response()->json($response, self::OK_CODE);
    }

    public function sendError(string $msg, array $data = [], int $code = self::NOT_FOUND_CODE): JsonResponse
    {
        return response()->json(self::errorResponse($msg, $data), $code);
    }
}
