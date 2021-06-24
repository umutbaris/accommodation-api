<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Services\AuthService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $loginResponse = $this->authService->loginUser($request->only('email', 'password'));
        if (isset($loginResponse['error'])) {
            return $this->sendError($loginResponse['error']);
        }

        return $this->sendSuccess($loginResponse['data']);
    }


    /**
     * @param  LogoutRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(LogoutRequest $request)
    {
        $logoutResponse = $this->authService->logoutUser($request->input('token'));

        if (isset($logoutResponse['error'])) {
            return $this->sendError($logoutResponse['error']['message'], $logoutResponse['error']['status_code']);
        }

        return $this->sendSuccess($logoutResponse);
    }
}
