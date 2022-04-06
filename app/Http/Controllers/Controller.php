<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $start_date;
    public $end_date;

    public function __construct()
    {
        $this->start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
    }
    public function successResponse($message, $data = [], $code = Response::HTTP_OK)
    {
    	$response = [
            'success' => true,
            'message' => $message,
        ];

        if(!empty($data)){

            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($error, $code = Response::HTTP_BAD_REQUEST)
    {
    	$response = [
            'success' => false,
            'error' => $error,
        ];

        return response()->json($response, $code);
    }
}
