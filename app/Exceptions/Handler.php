<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($this->shouldSkipReporting($e)) {
                return;
            }

            $context = $this->buildCustomExceptionContext($e);

            try {
                Log::error('Unhandled exception', $context + ['exception' => $e]);
            } catch (Throwable $loggingFailure) {
                $this->writeFallbackExceptionLog($e, $context, $loggingFailure);
            }
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof TokenMismatchException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang và thử lại.',
                ], 419);
            }

            $redirectTo = url()->previous() ?: url('/');

            if ($request->route()?->named('logout') || $request->is('logout')) {
                $redirectTo = url('/');
            }

            return redirect()
                ->to($redirectTo)
                ->with('error', 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang và thử lại.');
        }

        $response = parent::render($request, $e);

        if (method_exists($response, 'getStatusCode') && $response->getStatusCode() >= 500) {
            $requestId = $request->attributes->get('request_id') ?? $this->resolveRequestId($request);
            $request->attributes->set('request_id', $requestId);

            if (isset($response->headers)) {
                $response->headers->set('X-Request-Id', $requestId);
            }
        }

        return $response;
    }

    private function shouldSkipReporting(Throwable $e): bool
    {
        if ($e instanceof HttpExceptionInterface) {
            return $e->getStatusCode() < 500;
        }

        return false;
    }

    private function buildCustomExceptionContext(Throwable $e): array
    {
        $request = app()->bound('request') ? request() : null;
        $user = Auth::user();
        $requestId = $request ? ($request->attributes->get('request_id') ?? $this->resolveRequestId($request)) : (string) Str::uuid();

        if ($request) {
            $request->attributes->set('request_id', $requestId);
        }

        return [
            'request_id' => $requestId,
            'url' => $request?->fullUrl(),
            'method' => $request?->method(),
            'route' => $request?->route()?->getName(),
            'ip' => $request?->ip(),
            'user_id' => $user?->id,
            'user_role' => $user?->vaitro,
            'exception_class' => $e::class,
        ];
    }

    private function resolveRequestId(Request $request): string
    {
        $candidate = $request->headers->get('X-Request-Id');

        if (is_string($candidate) && $candidate !== '') {
            return $candidate;
        }

        return (string) Str::uuid();
    }

    private function writeFallbackExceptionLog(Throwable $e, array $context, Throwable $loggingFailure): void
    {
        try {
            $payload = [
                'at' => now()->toISOString(),
                'context' => $context,
                'exception' => [
                    'class' => $e::class,
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ],
                'logging_failure' => [
                    'class' => $loggingFailure::class,
                    'message' => $loggingFailure->getMessage(),
                ],
            ];

            $line = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).PHP_EOL;
            @file_put_contents(storage_path('logs/fallback-exceptions.log'), $line, FILE_APPEND);
        } catch (Throwable $finalFailure) {
            @error_log('Failed to write fallback exception log: '.$finalFailure->getMessage());
        }
    }
}
