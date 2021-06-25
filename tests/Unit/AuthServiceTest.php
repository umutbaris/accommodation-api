<?php

namespace Tests\Unit;

use App\Services\Auth\JwtService;
use App\Services\Auth\AuthService;
use PHPUnit\Framework\TestCase;
use JWTAuth;

class AuthServiceTest extends TestCase
{
    /**
     * Unit test for successful login.
     *
     * @return void
     */
    public function testLoginUserSuccessful()
    {
        $credentials = [
            'superuser@example.com',
            'superuser123'
        ];

        $jwtService = $this->createMock(JwtService::class);
        $jwtService->method('getToken')
            ->willReturn('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvbG9naW4iLCJpYXQiOjE2MjQ2MzA3OTgsImV4cCI6MTYyNDYzNDM5OCwibmJmIjoxNjI0NjMwNzk4LCJqdGkiOiJ4T1FlM0xEQnNscHJiZUlHIiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.vqFUv5UjcTn_tbYmqt1jQFaXXeA8nXa97HRTkh83jfY');


        $authService = new AuthService($jwtService);
        $result = $authService->loginUser($credentials);

        $this->assertArrayHasKey('data', $result);
    }

    /**
     * Unit test for failed login when token return false.
     *
     * @return void
     *
     */
    public function testLoginUserFail()
    {
        $credentials = [
            'superuser@example.com',
            'WrongPass'
        ];

        $jwtService = $this->createMock(JwtService::class);
        $jwtService->method('getToken')
            ->willReturn(false);

        $authService = new AuthService($jwtService);
        $result = $authService->loginUser($credentials);

        $this->assertArrayHasKey('error', $result);
    }

    /**
     * Unit test to check logout response
     *
     * @return void
     */
    public function testLogoutUser() {
        $jwtService = $this->createMock(JwtService::class);
        $jwtService->method('parseToken');
        $authService = new AuthService($jwtService);
        $result = $authService->logoutUser('token');

        $this->assertEquals([], $result);
    }
}
