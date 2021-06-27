<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Repositories\BaseRepository;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    protected $baseRepository;

    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function sendSuccess($data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ], $statusCode);
    }

    public function sendError(string $error, int $statusCode = 400, string $errorType=''): JsonResponse
    {
        $response = [
            'success' => false,
            'error' => $error
        ];

        if(!empty($errorType)){
            $response['errorType'] = $errorType;
        }
        return response()->json($response, $statusCode);
    }
}
