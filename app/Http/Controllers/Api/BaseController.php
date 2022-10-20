<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public const FORBIDDEN_CODE = 403;
    public const BAD_REQUEST_CODE = 400;
    public const INTERNAL_ERROR_CODE = 500;

    private const OK_CODE = 200;
    private const NOT_FOUND_CODE = 404;

    public function sendResponse(string $msg, array $data = [])
    {
        $response = [
            'status' => TRUE,
            'msg' => $msg,
            'data' => $data,
        ];

        return response()->json($response, self::OK_CODE);
    }

    public static function errorResponse(string $msg, array $data = [], int $code = 0): array
    {
        return [
            'status' => FALSE,
            'msg' => $msg,
            'data' => $data,
            'code' => $code,
        ];
    }

    public function sendError(string $msg, array $data = [], int $code = self::NOT_FOUND_CODE)
    {
        return response()->json(self::errorResponse($msg, $data), $code);
    }
}
