<?php

namespace Feature\API\User;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Models\UserFabricator;

class StoreTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $refresh = true;
    protected $namespace = 'App';

    public function testItShouldStoreUser(): void
    {
        $params = [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'lucas.silva@gmail.com',
            'mobile' => '99999999',
            'username' => 'lucas.bittencourt',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ];

        $result = $this->post('/api/users', $params);

        $result->assertStatus(201);

        $this->seeInDatabase('users', [
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'email' => $params['email'],
            'mobile' => $params['mobile'],
            'username' => $params['username'],
        ]);
    }

    public function testItShouldNotStoreUserWithoutRequiredFields(): void
    {
        $result = $this->post('/api/users', []);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'first_name' => 'The First name is required.',
            'last_name' => 'The Last name is required.',
            'mobile' => 'The Mobile is required.',
            'username' => 'The Username is required.',
            'email' => 'The Email is required.',
            'password' => 'The Password is required.',
            'password_confirm' => 'The password confirmation should match with the password.',
        ]);

        $this->assertTrue($this->db->table('users')->emptyTable());
    }

    public function testItShouldNotStoreUserWithAnInvalidEmail(): void
    {
        $params = [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'invalid-email',
            'mobile' => '99999999',
            'username' => 'lucas.bittencourt',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ];

        $result = $this->post('/api/users', $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'email' => 'The email "invalid-email" is invalid!',
        ]);

        $this->assertTrue($this->db->table('users')->emptyTable());
    }

    public function testItShouldNotStoreUserWithAnEmailAlreadyInUse(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $userFabricator->setOverrides([
            'email' => 'used.email@gmail.com',
        ])->create();

        $params = [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'used.email@gmail.com',
            'mobile' => '99999999',
            'username' => 'lucas.bittencourt',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ];

        $result = $this->post('/api/users', $params);

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

        $params = [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'lucas.silva@gmail.com',
            'mobile' => '99999999',
            'username' => 'admin',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ];

        $result = $this->post('/api/users', $params);

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

        $params = [
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'lucas.silva@gmail.com',
            'mobile' => '99999999',
            'username' => 'admin',
            'password' => 'secretPassword',
            'password_confirm' => 'secretPassword',
        ];

        $result = $this->post('/api/users', $params);

        $result->assertStatus(422);
        $result->assertJSONExact([
            'mobile' => 'Sorry. That mobile number has been used by other user.',
        ]);

        $this->assertTrue($this->db->table('users')->emptyTable());
    }
}