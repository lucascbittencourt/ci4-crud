<?php

namespace Feature\API\User;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Models\UserFabricator;

class UpdateTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $refresh = true;
    protected $namespace = 'App';

    public function testItShouldUpdateUser(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $user = $userFabricator->create();

        $params = [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'mobile' => $user['mobile'],
            'username' => 'admin',
        ];

        $result = $this->put('/api/users/' . $user['id'], $params);

        $result->assertStatus(204);

        $this->seeInDatabase('users', [
            'id' => $user['id'],
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'email' => $params['email'],
            'mobile' => $params['mobile'],
            'username' => 'admin',
        ]);
    }

    public function testItShouldNotUpdateUserWithoutRequiredFields(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $user = $userFabricator->create();

        $result = $this->put('/api/users/' . $user['id'], []);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'first_name' => 'The First name is required.',
            'last_name' => 'The Last name is required.',
            'mobile' => 'The Mobile is required.',
            'username' => 'The Username is required.',
            'email' => 'The Email is required.',
        ]);

        $this->assertTrue($this->db->table('users')->emptyTable());
    }

    public function testItShouldNotUpdateUserWithAnInvalidEmail(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $user = $userFabricator->create();

        $params = [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => 'invalid-email',
            'mobile' => $user['mobile'],
            'username' => $user['username'],
        ];

        $result = $this->put('/api/users/' . $user['id'], $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'email' => 'The email "invalid-email" is invalid!',
        ]);

        $this->assertTrue($this->db->table('users')->emptyTable());
    }

    public function testItShouldNotUpdateUserWithAnEmailAlreadyInUse(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $userFabricator->setOverrides([
            'email' => 'used.email@gmail.com',
        ])->create();

        $user = $userFabricator->setOverrides([
            'email' => 'user-email@gmail.com',
        ])->create();

        $params = [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => 'used.email@gmail.com',
            'mobile' => $user['mobile'],
            'username' => $user['username'],
        ];

        $result = $this->put('/api/users/' . $user['id'], $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'email' => 'Sorry. The email: "used.email@gmail.com" has been used by other user.',
        ]);

        $this->assertTrue($this->db->table('users')->emptyTable());
    }

    public function testItShouldNotStoreUserWithAnUsernameAlreadyInUse(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $userFabricator->setOverrides([
            'username' => 'admin',
        ])->create();

        $user = $userFabricator->setOverrides([
            'username' => 'nice-username',
        ])->create();

        $params = [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'mobile' => $user['mobile'],
            'username' => 'admin',
        ];

        $result = $this->put('/api/users/' . $user['id'], $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'username' => 'Sorry. The username: "admin" has been taken by other user. Try other.',
        ]);

        $this->assertTrue($this->db->table('users')->emptyTable());
    }

    public function testItShouldNotStoreUserWhenTheMobileNumberIsAlreadyInUse(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $userFabricator->setOverrides([
            'mobile' => '99999999',
        ])->create();

        $user = $userFabricator->setOverrides([
            'mobile' => '11111111',
        ])->create();

        $params = [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'mobile' => '99999999',
            'username' => $user['username'],
        ];

        $result = $this->put('/api/users/' . $user['id'], $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'mobile' => 'Sorry. That mobile number has been used by other user.',
        ]);

        $this->assertTrue($this->db->table('users')->emptyTable());
    }
}