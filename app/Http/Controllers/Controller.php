<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendData($data){
        return $this->sendMessage("", $data);
    }


    public function sendMessage($message, $data=null){
        $response = [
            "success"=> true,
            "message" => $message,
            "data" => $data
        ];
        return response()->json($response);
    }

    public function sendError($message, $status=500){
        $response = [
            "success"=> false,
            "message" => $message,
            "data" => null
        ];
        return response()->json($response, $status);
    }
}
