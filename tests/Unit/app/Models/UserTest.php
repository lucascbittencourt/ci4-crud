<?php

namespace Unit\app\Models;

use App\Models\User;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Models\UserFabricator;

class UserTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $refresh = true;
    protected $namespace = 'App';

    private readonly User $model;

    public function testItShouldHashThePasswordBeforeInsert(): void
    {
        $this->model->insert([
            'first_name' => 'Lucas',
            'last_name' => 'Silva',
            'email' => 'lucas.silva@gmail.com',
            'mobile' => '99999999',
            'username' => 'admin',
            'password' => 'secretPassword',
        ]);

        $this->assertTrue(password_verify('secretPassword', $this->model->first()['password']));
    }

    public function testItShouldHashThePasswordBeforeUpdate(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $user = $userFabricator->create();

        $this->model->update($user['id'], [
            'password' => 'secret',
        ]);

        $this->assertTrue(password_verify('secret', $this->model->first()['password']));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new User();
    }
}