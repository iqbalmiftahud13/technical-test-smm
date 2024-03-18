<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($result, $code = 200, $message = 'Success.')
    {
        $response = [
            'code' => $code,
            'success' => true,
            'messages' => $message,
            'data' => $result,
        ];

        return response()->json($response, $code);
    }
}
