<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Response
{
    protected function success($msg = 'Request successful', $data = null, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $msg,
            'data' => $data
        ], $code);
    }


    protected function failed($msg = 'Request failed', $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $msg,
        ], $code);
    }
}
