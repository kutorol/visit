<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * Get the default context variables for logging.
     *
     * @return array
     */
    protected function context()
    {
        return array_merge(parent::context(), [
            'user_id' => (int)(\Auth::user()?->id ?? 0),
        ]);
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        if (!$request->wantsJson() && !$this->isApi($request)) {
            return parent::render($request, $e);
        }

        $response = BaseController::errorResponse($e->getMessage(), [], (int)$e->getCode());

        return response()->json($this->extendMessage($response, $e), $this->getCode($e));
    }

    private function isApi($request): bool
    {
        return mb_strtolower($request->segment(1)) === 'api';
    }

    private function extendMessage(array $response, Throwable $e): array
    {
        if ($e instanceof ValidationException) {
            $response = $this->validateExtended($response, $e);
        }

        return $response;
    }

    private function validateExtended(array $response, ValidationException $e): array
    {
        $response['msg'] = __('validation.failed_validation');
        $response['data']['errs'] = [];
        foreach ($e->errors() as $errors) {
            foreach ($errors as $error) {
                $response['data']['errs'][] = $error;
            }
        }

        return $response;
    }

    private function getCode(Throwable $e): int
    {
        if ($e instanceof AuthorizationException) {
            return BaseController::FORBIDDEN_CODE;
        } elseif ($e instanceof ValidationException) {
            return BaseController::BAD_REQUEST_CODE;
        }

        return BaseController::INTERNAL_ERROR_CODE;
    }
}
