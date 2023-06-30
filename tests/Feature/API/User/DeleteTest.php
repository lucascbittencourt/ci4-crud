<?php

namespace Feature\API\User;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Models\UserFabricator;

class DeleteTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $refresh = true;
    protected $namespace = 'App';

    public function testItShouldDeleteUser(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $user = $userFabricator->create();

        $result = $this->delete('/api/users/' . $user['id']);

        $result->assertStatus(204);
        $this->assertTrue($this->db->table('users')->emptyTable());
    }
}