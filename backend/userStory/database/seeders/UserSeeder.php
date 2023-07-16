<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userList = [
            [ 'name' => 'UserWantToOrder', 'email' => 'user@test.com', 'password' => 'user123456789', 'role' => 2 ],
            [ 'name' => 'AdminWantToAdd', 'email' => 'admin@test.com', 'password' => 'admin123456789', 'role' => 1 ]
        ];
        $faker = Faker::create();
        foreach($userList as $k){
            $user = User::create([
                'name' => $faker->name,
                'email' => $k['email'],
                'password' => $k['password'],
                'role' => $k['role'],
                'status' => 2,
                'profile_picture' => ""
            ]);
        }
    }
}
