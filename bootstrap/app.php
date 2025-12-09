<?php

use Illuminate\Foundation\Application;
use App\Http\Controllers\ApiController;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

$apiController = new ApiController();

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) use ($apiController): void {
        $exceptions->render(
            function (ModelNotFoundException $ex) use ($apiController) {
                return $apiController->errorResponse($ex->getMessage(), 404);
            }
        );
        $exceptions->render(
            function (NotFoundHttpException $ex) use ($apiController) {
                return $apiController->errorResponse($ex->getMessage(), 404);
            }
        );
        $exceptions->render(
            function (MethodNotAllowedHttpException $ex) use ($apiController) {
                return $apiController->errorResponse($ex->getMessage(), 404);
            }
        );
        $exceptions->render(
            function (Exception $ex) use ($apiController) {
                return $apiController->errorResponse($ex->getMessage(), 404);
            }
        );
        $exceptions->render(
            function (Error $ex) use ($apiController) {
                return $apiController->errorResponse($ex->getMessage(), 404);
            }
        );
        $exceptions->render(
            function (QueryException $ex) use ($apiController) {
                return $apiController->errorResponse($ex->getMessage(), 404);
            }
        );
    })->create();
