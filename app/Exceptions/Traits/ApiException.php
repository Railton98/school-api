<?php

namespace App\Exceptions\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpFoundation\Response;

trait ApiException {

    /**
     * Treat exceptions to api
     */
    protected function getJsonException($request, $exception)
    {
        if ($exception instanceof ThrottleRequestsException) {
            return $this->manyRequestsException($exception);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->notFoundException();
        }

        if ($exception instanceof HttpException) {
            return $this->httpException($exception);
        }

        if ($exception instanceof ValidationException) {
            return $this->validationException($exception);
        }

        return $this->genericException();
    }

    /**
     * Method for error 404
     */
    protected function notFoundException()
    {
        return $this->getResponse(
            'Resource Not Found',
            '01',
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Method for many Requets
     */
    protected function manyRequestsException($exception)
    {
        return $this->getResponse(
            $exception->getMessage(),
            '04',
            Response::HTTP_TOO_MANY_REQUESTS
        );
    }

    /**
     * Method for error 500
     */
    protected function genericException()
    {
        return $this->getResponse(
            'Internal Server Error',
            '02',
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Method for http errors
     */
    protected function httpException($exception)
    {
        return $this->getResponse(
            'Method Not Allowed',
            '03',
            $exception->getStatusCode()
        );
    }

    /**
     * Method for validations errors
     */
    protected function validationException($exception)
    {
        return response()->json($exception->errors(), $exception->status);
    }

    /**
     * Returns message in json format
     */
    protected function getResponse($message, $code, $status)
    {
        return response()->json([
            'errors' => [
                [
                    'status' => $status,
                    'code' => $code,
                    'message' => $message
                ],
            ]
        ], $status);
    }

}
