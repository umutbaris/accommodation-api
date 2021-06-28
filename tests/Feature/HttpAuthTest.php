<?php

namespace Tests\Feature;

use Tests\TestCase;

class HttpAuthTest extends TestCase
{
    /**
     * A basic test to site up
     *
     * @return void
     */
    public function testHomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test to api authorized
     *
     * @return void
     */
    public function testApiAuthorized()
    {
        $response = $this->get(route('getHotels'));

        $response->assertStatus(401);
    }

    /**
     * Test to api login
     *
     * @return void
     */
    public function testLogin()
    {
        $body = [
            'email' => 'superuser@example.com',
            'password' => 'superuser123',

        ];

        $this->json('POST', 'api/login', $body, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
            ]);
    }

    /**
     * Test to api logout
     *
     * @return void
     */
    public function testLogout()
    {
        $body = [
            'email' => 'superuser@example.com',
            'password' => 'superuser123',

        ];
        $token = $this->json('POST', 'api/login', $body, ['Accept' => 'application/json'])->getData()->data->token;
        $header = [
            'Authorization' => 'Bearer ' . $token
        ];

        $this->json('POST', 'api/logout', [], $header)
            ->assertStatus(200);


    }

    /**
     * Test to api logout wrong token
     *
     * @return void
     */
    public function testLogoutWrongToken()
    {
        $body = [
            'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvbG9naW4iLCJpYXQiOjE2MjQ2NDE2NDgsImV4cCI6MTYyNDY0NTI0OCwibmJmIjoxNjI0NjQxNjQ4LCJqdGkiOiJ5ODdFOXR0SEE2ZVZVZUF6Iiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.zP0PN2N7HrRR7VqstBKF0-F6IV0OzG3n6Roj-Mgx-Wk'
        ];

        $this->json('POST', 'api/logout', $body, ['Accept' => 'application/json'])
            ->assertStatus(401);
    }
}
