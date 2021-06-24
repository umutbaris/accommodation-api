<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'email' => 'superuser@example.com',
                'email_verified_at' => now(),
                'password' => 'superuser123',
                'verified' => 1,
                'remember_token' => Str::random(10)
            ],
            [
                'email' => 'user@example.com',
                'email_verified_at' => now(),
                'password' => 'user123',
                'verified' => 1,
                'remember_token' => Str::random(10)
            ],
        ];


        foreach ($users as $user) {
            $user['password'] = bcrypt($user['password']);
            User::create($user);
        }
    }
}
