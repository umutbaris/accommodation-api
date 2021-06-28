<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Services\Auth\AuthService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseApiController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    /**
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $loginResponse = $this->authService->loginUser($request->only('email', 'password'));
        if (isset($loginResponse['error'])) {
            return $this->sendError($loginResponse['error']);
        }

        return $this->sendSuccess($loginResponse['data']);
    }

    /**
     * @param  LogoutRequest  $request
     * @return JsonResponse
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        $logoutResponse = $this->authService->logoutUser($request->header('Authorization'));

        if (isset($logoutResponse['error'])) {
            return $this->sendError($logoutResponse['error']['message'], $logoutResponse['error']['status_code']);
        }

        return $this->sendSuccess($logoutResponse);
    }
}
