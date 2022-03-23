<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function sendResponse($res, $msg)
    {
        $response = [
            'success' => true,
            'data' => $res,
            'message' => $msg,
        ];
        return response()->json($response, 200);
    }

    protected function sendError($error, $errorMsg = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];
        if (!empty($errorMsg)) {
            $response['data'] = $errorMsg;
        }
        return response()->json($response, $code);
    }
}
