<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponder
{
    public function successResponse($data, $message, $statusCode = Response::HTTP_OK)
    {
        if (!$message) {
            $message = Response::$statusTexts[$statusCode];
        }
        return response()->json
        ([
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function errorResponse($message = '', $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        if (!$message) {
            $message = Response::$statusTexts[$statusCode];
        }
        return response()->json
        ([
            'status_code' => $statusCode,
            'message' => ['errors' => $message],
            'data' => null
        ]);
    }

    public function okResponse($data, $message = '')
    {
        return $this->successResponse($data, $message);
    }

    public function createdResponse($data, $message = '')
    {
        return $this->successResponse($data, $message, Response::HTTP_CREATED);
    }

    public function noContentResponse($message = '')
    {
        return $this->successResponse([], $message, Response::HTTP_NO_CONTENT);
    }

    public function badRequestResponse($message = '')
    {
        return $this->errorResponse($message, Response::HTTP_BAD_REQUEST);
    }

    public function unauthorizedResponse($message = '')
    {
        return $this->errorResponse($message, Response::HTTP_UNAUTHORIZED);
    }

    public function forbiddenResponse($message = '')
    {
        return $this->errorResponse($message, Response::HTTP_FORBIDDEN);
    }

    public function notFoundResponse($message = '')
    {
        return $this->errorResponse($message, Response::HTTP_NOT_FOUND);
    }

    public function conflictResponse($message = '')
    {
        return $this->errorResponse($message, Response::HTTP_CONFLICT);
    }

    public function unprocessableResponse($message = '')
    {
        return $this->errorResponse($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function userWithToken($data, $token = '', $message = '', $status = Response::HTTP_OK)
    {
        $array = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'token' => $token,
        ];
        return response($array, $status);
    }
}
