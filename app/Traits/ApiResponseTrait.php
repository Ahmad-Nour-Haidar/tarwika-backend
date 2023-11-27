<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponseTrait
{

    public function successResponse($data, $message = '', $status = Response::HTTP_OK)
    {
        $array = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
        return response($array, $status);
    }

    public function loginResponse($data, $token = '', $message = '', $status = Response::HTTP_OK)
    {
        $array = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'token' => $token,
        ];
        return response($array, $status);
    }

    public function errorResponse($message = '', $errorMessages = null, $status = Response::HTTP_BAD_REQUEST)
    {
        $array = [
            'status' => $status,
            'message' => $message,
//            'data' => $data,
            'error_messages' => $errorMessages,
        ];
        return response($array, $status);
    }


}
