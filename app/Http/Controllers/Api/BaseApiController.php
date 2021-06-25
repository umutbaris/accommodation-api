<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\BaseRepository;

class BaseApiController extends Controller
{
    protected $baseRepository;

    public function __construct(BaseRepository $baseRepository)
    {
        $this->BaseRepository = $baseRepository;
    }

    public function sendRaw($data = [], $statusCode = 200) {
        return response()->json($data, $statusCode);
    }

    public function sendSuccess($data = [], $statusCode = 200) {
        return response()->json([
            'success' => true,
            'data' => $data
        ], $statusCode);
    }

    public function sendError($error, $statusCode = 400, $errorType='') {
        $response = [
            'success' => false,
            'error' => $error
        ];

        if(!empty($errorType)){
            $response['errorType'] = $errorType;
        }
        return response()->json($response, $statusCode);
    }

    public function sendResponse($result) {
        if(is_array($result) && array_key_exists('Error', $result)) {
            return $this->sendError($result);
        }

        return $this->sendSuccess($result);
    }

    public function logActivity($description, $instance = null, $properties = [])
    {
        if ($instance!= null) $instance = $instance->getNewInstance();
        activity()
//            ->on($instance)
            ->withProperties($properties)
            ->log($description);
    }
}
