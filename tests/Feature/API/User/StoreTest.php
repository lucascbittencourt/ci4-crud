<?php

namespace Feature\API\User;

use App\Models\User;
use CodeIgniter\Test\Fabricator;
use Tests\Support\TestCase;

class StoreTest extends TestCase
{
    public function testItShouldStoreUser(): void
    {
        $userFabricator = new Fabricator(User::class);
        $user = $userFabricator->create();

        $params = [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'lucas.silva@gmail.com',
            'mobile' => '99999999',
            'username' => 'lucas.bittencourt',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ];

        $result = $this->actingAs($user)->post('/api/users', $params);

        $result->assertStatus(201);

        $this->seeInDatabase('users', [
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'mobile' => $params['mobile'],
            'username' => $params['username'],
        ]);
    }

    public function testItShouldNotStoreUserWithoutRequiredFields(): void
    {
        $userFabricator = new Fabricator(User::class);
        $user = $userFabricator->create();

        $result = $this->actingAs($user)->post('/api/users', []);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'errors' => [
                'first_name' => 'The First name is required.',
                'last_name' => 'The Last name is required.',
                'mobile' => 'The Mobile is required.',
                'username' => 'The Username is required.',
                'email' => 'The Email Address is required.',
                'password' => 'The Password is required.',
                'password_confirm' => 'The Password (again) is required.',
            ],
        ]);
    }

    public function testItShouldNotStoreUserWithAnInvalidEmail(): void
    {
        $userFabricator = new Fabricator(User::class);
        $user = $userFabricator->create();

        $params = [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'invalid-email',
            'mobile' => '99999999',
            'username' => 'lucas.bittencourt',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ];

        $result = $this->actingAs($user)->post('/api/users', $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'errors' => [
                'email' => 'The email "invalid-email" is invalid!',
            ],
        ]);
    }

    public function testItShouldNotStoreUserWithAnEmailAlreadyInUse(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->setOverrides([
            'email' => 'used.email@gmail.com',
        ])->create();

        $user = $userFabricator->setOverrides()->create();

        $params = [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'used.email@gmail.com',
            'mobile' => '99999999',
            'username' => 'lucas.bittencourt',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ];

        $result = $this->actingAs($user)->post('/api/users', $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'errors' => [
                'email' => 'Sorry. The email: "used.email@gmail.com" has been used by other user.',
            ],
        ]);
    }

    public function testItShouldNotStoreUserWithAnUsernameAlreadyInUse(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->setOverrides([
            'username' => 'admin',
        ])->create();

        $user = $userFabricator->setOverrides()->create();

        $params = [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'lucas.silva@gmail.com',
            'mobile' => '99999999',
            'username' => 'admin',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ];

        $result = $this->actingAs($user)->post('/api/users', $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'errors' => [
                'username' => 'Sorry. The username: "admin" has been taken by other user. Try other.',
            ],
        ]);
    }

    public function testItShouldNotStoreUserWhenTheMobileNumberIsAlreadyInUse(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->setOverrides([
            'mobile' => '99999999',
        ])->create();

        $user = $userFabricator->create();

        $params = [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'lucas.silva@gmail.com',
            'mobile' => '99999999',
            'username' => 'admin',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ];

        $result = $this->actingAs($user)->post('/api/users', $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'errors' => [
                'mobile' => 'Sorry. That mobile number has been used by other user.',
            ],
        ]);
    }

    public function testItShouldNotStoreUserWhenUserIsNotAuthenticated(): void
    {
        $result = $this->post('/api/users', [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'lucas.silva@gmail.com',
            'mobile' => '99999999',
            'username' => 'lucas.bittencourt',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ]);

        $result->assertRedirect();
    }
}