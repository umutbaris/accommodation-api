<?php


namespace App\Services\Auth;


use JWTAuth;


class JwtService
{
    /**
     * Convert credentials to token
     *
     * @param  array  $credentials
     * @return mixed
     */
    public function getToken(array $credentials)
    {
        return JWTAuth::attempt($credentials);
    }

    /**
     * Parsing Token
     *
     * @param  string  $token
     * @return mixed
     */
    public function parseToken(string $token)
    {
        return JWTAuth::parseToken()->invalidate($token);
    }
}