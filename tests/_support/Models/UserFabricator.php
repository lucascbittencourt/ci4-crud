<?php

namespace Tests\Support\Models;

use App\Models\User;
use Faker\Generator;

class UserFabricator extends User
{
    public function fake(Generator $faker): array
    {
        return [
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->email(),
            'mobile' => $faker->phoneNumber(),
            'username' => $faker->userName(),
            'password' => password_hash($faker->password(), PASSWORD_DEFAULT),
        ];
    }
}
