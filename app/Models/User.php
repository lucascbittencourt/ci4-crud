<?php

namespace App\Models;

use CodeIgniter\Shield\Entities\User as UserEntity;
use CodeIgniter\Shield\Models\UserModel;
use Faker\Generator;

class User extends UserModel
{
    protected $allowedFields = [
        'first_name',
        'last_name',
        'mobile',
        'username',
        'status',
        'status_message',
        'active',
        'last_active',
        'deleted_at',
    ];

    public function fake(Generator &$faker): UserEntity
    {
        return new UserEntity([
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'mobile' => $faker->unique()->phoneNumber(),
            'username' => $faker->unique()->userName(),
            'active' => true,
        ]);
    }
}
