<?php

namespace Feature\API\User;

use App\Models\User;
use CodeIgniter\Test\Fabricator;
use Tests\Support\TestCase;

class UpdateTest extends TestCase
{
    public function testItShouldUpdateUser(): void
    {
        $userFabricator = new Fabricator(User::class);
        $user = $userFabricator->setOverrides([
            'email' => 'user@email.com',
        ])->create();

        $params = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'username' => 'admin',
            'password' => null,
            'password_confirm' => null,
        ];

        $result = $this->actingAs($user)->put('/api/users/' . $user->id, $params);

        $result->assertStatus(204);
        $this->seeInDatabase('users', [
            'id' => $user->id,
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'mobile' => $params['mobile'],
            'username' => 'admin',
        ]);
    }

    public function testItShouldNotUpdateUserWithoutRequiredFields(): void
    {
        $userFabricator = new Fabricator(User::class);
        $user = $userFabricator->create();

        $result = $this->actingAs($user)->put('/api/users/' . $user->id, []);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'errors' => [
                'first_name' => 'The First name is required.',
                'last_name' => 'The Last name is required.',
                'mobile' => 'The Mobile is required.',
                'username' => 'The Username is required.',
                'email' => 'The Email is required.',
            ],
        ]);
    }

    public function testItShouldNotUpdateUserWithAnInvalidEmail(): void
    {
        $userFabricator = new Fabricator(User::class);
        $user = $userFabricator->create();

        $params = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => 'invalid-email',
            'mobile' => $user->mobile,
            'username' => $user->username,
        ];

        $result = $this->actingAs($user)->put('/api/users/' . $user->id, $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'errors' => [
                'email' => 'The email "invalid-email" is invalid!',
            ],
        ]);
        $this->dontSeeInDatabase('auth_identities', [
            'user_id' => $user->id,
            'secret' => $params['email'],
        ]);
    }

    public function testItShouldNotUpdateUserWithAnEmailAlreadyInUse(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->setOverrides([
            'email' => 'used.email@gmail.com',
        ])->create();

        $user = $userFabricator->setOverrides([
            'email' => 'user-email@gmail.com',
        ])->create();

        $params = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => 'used.email@gmail.com',
            'mobile' => $user->mobile,
            'username' => $user->username,
        ];

        $result = $this->actingAs($user)->put('/api/users/' . $user->id, $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'errors' => [
                'email' => 'Sorry. The email: "used.email@gmail.com" has been used by other user.',
            ],
        ]);
        $this->dontSeeInDatabase('auth_identities', [
            'user_id' => $user->id,
            'secret' => $params['email'],
        ]);
    }

    public function testItShouldNotUpdateUserWithAnUsernameAlreadyInUse(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->setOverrides([
            'username' => 'admin',
        ])->create();

        $user = $userFabricator->setOverrides()->create();

        $params = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => 'user@email.com',
            'mobile' => $user->mobile,
            'username' => 'admin',
        ];

        $result = $this->actingAs($user)->put('/api/users/' . $user->id, $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'errors' => [
                'username' => 'Sorry. The username: "admin" has been taken by other user. Try other.',
            ],
        ]);
        $this->dontSeeInDatabase('users', [
            'id' => $user->id,
            'username' => $params['username'],
        ]);
    }

    public function testItShouldNotUpdateUserWhenTheMobileNumberIsAlreadyInUse(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->setOverrides([
            'mobile' => '99999999',
        ])->create();

        $user = $userFabricator->setOverrides()->create();

        $params = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => 'user@email.com',
            'mobile' => '99999999',
            'username' => $user->username,
        ];

        $result = $this->actingAs($user)->put('/api/users/' . $user->id, $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'errors' => [
                'mobile' => 'Sorry. That mobile number has been used by other user.',
            ],
        ]);
        $this->dontSeeInDatabase('users', [
            'id' => $user->id,
            'mobile' => $params['mobile'],
        ]);
    }
}