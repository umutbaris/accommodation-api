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

    /**
     * @param  array  $data
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function sendSuccess($data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ], $statusCode);
    }

    /**
     * @param  string  $error
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function sendError(string $error, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => $error
        ], $statusCode);
    }
}
