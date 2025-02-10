<?php

namespace App\Traits;

trait ApiResponse
{
    protected function success($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ], $code);
    }

    protected function error($message = 'Error', $code = 400, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'code' => $code,
            'errors' => $data,
        ], $code);
    }

    protected function created($data, $message = 'Created')
    {
        return $this->success($data, $message, 201);
    }

    protected function noContent($message = 'No Content')
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'code' => 204,
            'data' => null,
        ], 204);
    }

    protected function unauthorized($message = 'Unauthorized')
    {
        return $this->error($message, 401);
    }

    protected function forbidden($message = 'Forbidden')
    {
        return $this->error($message, 403);
    }

    protected function notFound($message = 'Not Found')
    {
        return $this->error($message, 404);
    }

    protected function internalError($message = 'Internal Server Error')
    {
        return $this->error($message, 500);
    }

    protected function validationError($message = 'Validation Error', $data)
    {
        return $this->error($message, 422, $data);
    }
}