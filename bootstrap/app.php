<?php

use App\Exceptions\ApiException;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {})
    ->withExceptions(function (Exceptions $exceptions): void {
        // 1) Cualquier ApiException
        $exceptions->render(function (ApiException $e, Request $request) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => $e->getErrorCode(),
                    'message' => $e->getMessage(),
                    'data' => $e->getData(),
                ],
            ], $e->getStatusCode());
        });
        // 2) Errores de validación
        $exceptions->render(function (
            ValidationException $e,
            Request $request
        ) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => 'Datos no válidos',
                    'data' => $e->errors(),
                ],
            ], 422);
        });
        // 3) ModelNotFound
        $exceptions->render(function (
            ModelNotFoundException $e,
            Request $request
        ) {
            $model = class_basename($e->getModel());
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'MODEL_NOT_FOUND',
                    'message' => "{$model} no encontrado",
                    'data' => [],
                ],
            ], 404);
        });
    })->create();
