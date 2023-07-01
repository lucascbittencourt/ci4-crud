<?php

namespace Feature\API\User;

use App\Models\User;
use CodeIgniter\Test\Fabricator;
use Tests\Support\TestCase;

class DeleteTest extends TestCase
{
    public function testItShouldDeleteUser(): void
    {
        $userFabricator = new Fabricator(User::class);
        $user = $userFabricator->create();

        $result = $this->actingAs($user)->delete('/api/users/' . $user->id);

        $result->assertStatus(204);
        $this->assertTrue($this->db->table('users')->emptyTable());
    }

    public function testItShouldNotDeleteUserWhenUserIsNotAuthenticated(): void
    {
        $userFabricator = new Fabricator(User::class);
        $user = $userFabricator->create();

        $result = $this->delete('/api/users/' . $user->id);

        $result->assertStatus(302);
    }
}