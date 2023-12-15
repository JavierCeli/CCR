<?php

namespace App\Models;

use Illuminate\Http\Response;

class MDSFApiResponse
{
    public $code = 1000;
    public $message = '';
    public $time;
    
    public $data = [];

    public $http_code = Response::HTTP_OK;

    public function json(){
        return new Response(
            [
                'code' => $this->code,
                'message' => $this->message,
                'time' => (new \DateTime())->format('Y-m-d H:i:s.u'),
                'data' => $this->data
            ], 
            $this->http_code);
    }

    public static function cast($response_http){
        $castResponse = new MDSFApiResponse();
        $jsonResponse = json_decode($response_http->getBody());
        $castResponse->code = $jsonResponse->code;
        $castResponse->message = $jsonResponse->message;
        $castResponse->time = $jsonResponse->time;
        $castResponse->data = $jsonResponse->data;
        $castResponse->http_code = $response_http->getStatusCode();
        return $castResponse;
    }

    public static function exceptionResponse($message, $e){
        /*Se responde HTTP_OK dado que es un error controlado*/
        $eResponse = new MDSFApiResponse();
        $eResponse->code = 1400;
        $eResponse->message = $message;
        $eResponse->data = $e->getMessage();
        \Log::error($eResponse->message);
        \Log::error($e);
        return $eResponse;
    }

    public static function strException($message, $e){
        return ($message . " " . (isset($e->response) ? $e->response : $e));
    }

    public function __toString(){
        return json_encode($this);
    }
}
