<?php


namespace App\Services\Auth;


use App\Services\Auth\JwtService;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthService
{

    /**
     * AuthService constructor.
     * @param  JwtService  $jwtService
     */
    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * @param  array  $credentials
     * @return array[]
     */
    public function loginUser(array $credentials)
    {
        try {
            if (!$token = $this->jwtService->getToken($credentials)) {
                return [
                    'error' => [
                        'status_code' => 401,
                        'message' => 'Email or password is invalid.'
                    ]
                ];
            }
        } catch (JWTException $e) {
            // Something went wrong with JWT auth
            return [
                'error' => [
                    'status_code' => 500,
                    'message' => 'Failed to login, please try again.'
                ]
            ];
        }

        return $this->loginSuccessful($token);
    }


    /**
     * Successful login logging and perparing response
     *
     * @param $token
     * @return array[]
     */
    public function loginSuccessful($token)
    {
        $login_time = now();
        $expiration_time = strtotime($login_time) + env('JWT_TTL');

        return [
            'data' => [
                'token' => $token,
                'expiration' =>  date('H:i:s', $expiration_time),
            ]
        ];
    }

    /**
     * @param $token
     * @return array|array[]
     */
    public function logoutUser($token)
    {
        try {
            // Attempt to invalidate the JWT token
            $this->jwtService->parseToken($token);
            return [];
        } catch (JWTException $e) {
            // Something went wrong with invalidating the token
            return [
                'error' => [
                    'status_code' => 500,
                    'message' => 'Failed to logout, please try again.'
                ]
            ];
        }
    }
}