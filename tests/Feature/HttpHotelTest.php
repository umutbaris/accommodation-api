<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HttpHotelTest extends TestCase
{
    /**
     * Test to get all hotels
     *
     * @return void
     */
    public function testGetHotels()
    {
        $header = [
            'Authorization' => 'Bearer ' . $this->loginToApi()
        ];

        $this->json('GET', 'api/items', ['Accept' => 'application/json'], $header)
            ->assertStatus(200);
    }

    /**
     * Test to get hotel with id
     *
     * @return void
     */
    public function testGetHotel()
    {
        $header = [
            'Authorization' => 'Bearer ' . $this->loginToApi()
        ];

        $this->json('GET', 'api/items/1', ['Accept' => 'application/json'], $header)
            ->assertStatus(200);
    }

    /**
     * Test to update hotel
     *
     * @return void
     */
    public function testUpdateHotel()
    {
        $header = [
            'Authorization' => 'Bearer ' . $this->loginToApi()
        ];

        $body = [
            'reputation' => 500
        ];

        $this->json('PUT', 'api/items/1', $body, $header)
            ->assertStatus(200);
    }

    /**
     * Test to create hotel
     *
     * @return void
     */
    public function testCreateHotel()
    {
        $header = [
            'Authorization' => 'Bearer ' . $this->loginToApi()
        ];

        $faker = Factory::create();
        $body = [
            "category_id"=> 1,
            "name" => $faker->name,
            "rating" => 0,
            "reputation" => 900,
            "availability" => 1,
            "price" => 1,
            "image" => "https://www.hotel.com",
            "location" => [
                "city"=> "Cuernavaca",
                "state"=> "Morelos",
                "country"=> "Mexico",
                "zip_code"=> "12345"
            ]
        ];

        $this->json('POST', 'api/items', $body, $header)
            ->assertStatus(200);
    }

    /**
     * Test to delete hotel
     *
     * @return void
     */
    public function testDeleteHotel()
    {
        $header = [
            'Authorization' => 'Bearer ' . $this->loginToApi()
        ];

        $id = DB::table('hotels')->latest()->first()->id;
        $this->json('DELETE', 'api/items/' . $id, [], $header)
            ->assertStatus(204);
    }

    /**
     * @return false|string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function loginToApi()
    {
        $token = $this->checkExpiration();
        if ($token) {
            return $token;
        }

        $body = [
            'email' => 'superuser@example.com',
            'password' => 'superuser123',

        ];
        $loginResponse = $this->json('POST', 'api/login', $body, ['Accept' => 'application/json'])->getData()->data;
        $token = $loginResponse->token;
        Storage::disk('local')->put('token.txt', $token);
        Storage::disk('local')->put('expiration.txt', $loginResponse->expiration);

        return $token;
    }

    /**
     * @return false|string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function checkExpiration()
    {
        if (Storage::disk('local')->has('token.txt') && Storage::disk('local')->has('expiration.txt')) {
            $expiration = trim(str_replace('(Coordinated Universal Time)', '', Storage::disk('local')->get('expiration.txt')));
            $expirationDate = \DateTime::createFromFormat('D M d Y H:i:s T', $expiration);
            $dateUtc = new \DateTime("now", new \DateTimeZone("GMT+0000"));
            if ($expirationDate > $dateUtc) {
                return Storage::disk('local')->get('token.txt');
            }
        }

        return false;
    }
}
