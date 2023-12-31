<?php

namespace App\Core;

use App\Exceptions\AuthorizationException;
use App\Exceptions\EnvPropertyValueException;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\MethodNotFoundException;
use App\Exceptions\RateLimitExceededException;
use App\Exceptions\RouteNotFoundException;
use App\Exceptions\ViewNotFoundException;
use Throwable;

class ExceptionHandler
{

    /**
     * Handle different types of exceptions and return appropriate status code and response body.
     *
     * @param Throwable $exception The exception to handle.
     * @return void
     */
    public static function handle(Throwable $exception)
    {
        $statusCode = 500;
        $responseBody = ['message' => 'Internal Server Error'];

        if ($exception instanceof ViewNotFoundException) {
            $statusCode = 404;
            $responseBody = ['message' => 'View Not Found'];
        } elseif ($exception instanceof RouteNotFoundException) {
            $statusCode = 404;
            $responseBody = ['message' => 'Route Not Found'];
        } elseif ($exception instanceof RateLimitExceededException) {
            $statusCode = 429;
            $responseBody = ['message' => 'Too Many Requests'];
        } elseif ($exception instanceof EnvPropertyValueException) {
            $statusCode = 519;
            $responseBody = ['message' => $exception->getMessage()];
        } elseif ($exception instanceof AuthorizationException) {
            $statusCode = 401;
            $responseBody = ['message' => 'Unauthorized'];
        } elseif ($exception instanceof MethodNotFoundException) {
            $statusCode = 404;
            $responseBody = ['message' => $exception->getMessage()];
        }
        elseif ($exception instanceof MethodNotAllowedException) {
            $statusCode = 405;
            $responseBody = ['message' => $exception->getMessage()];
        }

        if (Env::get('APP_DEBUG', "FALSE") === "TRUE") {
            $responseBody['message'] = $exception->getMessage();
            $responseBody['trace'] = $exception->getTrace();

        }

        $responseBody['statusCode'] = $statusCode;
        $acceptedTypes = array_map('trim', explode(',', $_SERVER['HTTP_ACCEPT']));

        if (in_array('application/json', $acceptedTypes)) {
            header('Content-Type: application/json');
            http_response_code($statusCode); // Doğru HTTP yanıt kodunu ayarla
            echo json_encode($responseBody);
        } elseif (in_array('multipart/form-data', $acceptedTypes)) {
            header('Content-Type: multipart/form-data');
            http_response_code($statusCode); // Doğru HTTP yanıt kodunu ayarla
            // Multipart/form-data yanıtı oluşturmak için burada gerekli kodları yazabilirsin
        } else {
            http_response_code($statusCode); // Doğru HTTP yanıt kodunu ayarla
            view('error6', [
                'exception' => $responseBody
            ]);
        }
    }
}
