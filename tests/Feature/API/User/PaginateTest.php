<?php

namespace Feature\API\User;

use App\Models\User;
use CodeIgniter\Test\Fabricator;
use Tests\Support\TestCase;

class PaginateTest extends TestCase
{
    public function testItShouldReturnUsersPaginate(): void
    {
        $userFabricator = new Fabricator(User::class);
        $user = $userFabricator->create();

        $result = $this->actingAs($user)->get('/api/users');

        $result->assertStatus(200);
        $result->assertJSONExact([
            'data' => [
                [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'username' => $user->username,
                ]
            ],
            'recordsTotal' => 1,
            'recordsFiltered' => 1,
        ]);
    }

    public function testItShouldReturnUsersPaginateWithCustomPerPage(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->create(9);

        $user = $userFabricator->create();

        $params = [
            'length' => 5,
        ];

        $result = $this->actingAs($user)->get('/api/users', $params);

        $data = json_decode($result->getJSON(), true);

        $result->assertStatus(200);
        $this->assertCount(5, $data['data']);
    }

    public function testItShouldReturnUsersPaginateSearchingByFirstName(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->create(4);

        $user = $userFabricator->setOverrides([
            'first_name' => 'Lucas',
        ])->create();

        $params = [
            'search' => [
                'value' => 'lucas',
            ],
        ];

        $result = $this->actingAs($user)->get('/api/users', $params);

        $result->assertStatus(200);
        $result->assertJSONExact([
            'data' => [
                [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'username' => $user->username,
                ]
            ],
            'recordsTotal' => 5,
            'recordsFiltered' => 1,
        ]);
    }

    public function testItShouldReturnUsersPaginateSearchingByLastName(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->create(4);

        $user = $userFabricator->setOverrides([
            'last_name' => 'Sauro',
        ])->create();

        $params = [
            'search' => [
                'value' => 'sauro',
            ],
        ];

        $result = $this->actingAs($user)->get('/api/users', $params);

        $result->assertStatus(200);
        $result->assertJSONExact([
            'data' => [
                [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'username' => $user->username,
                ]
            ],
            'recordsTotal' => 5,
            'recordsFiltered' => 1,
        ]);
    }

    public function testItShouldReturnUsersPaginateSearchingByUsername(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->create(4);

        $user = $userFabricator->setOverrides([
            'username' => 'datingPx',
        ])->create();

        $params = [
            'search' => [
                'value' => 'datingpx',
            ],
        ];

        $result = $this->actingAs($user)->get('/api/users', $params);

        $result->assertStatus(200);
        $result->assertJSONExact([
            'data' => [
                [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'username' => $user->username,
                ]
            ],
            'recordsTotal' => 5,
            'recordsFiltered' => 1,
        ]);
    }

    public function testItShouldReturnUsersPaginateSearchingByEmail(): void
    {
        $userFabricator = new Fabricator(User::class);
        $userFabricator->create(4);

        $user = $userFabricator->setOverrides([
            'email' => 'lucas@gmail.com',
        ])->create();

        $params = [
            'search' => [
                'value' => 'lucas@gmail.com',
            ],
        ];

        $result = $this->actingAs($user)->get('/api/users', $params);

        $result->assertStatus(200);
        $result->assertJSONExact([
            'data' => [
                [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'username' => $user->username,
                ]
            ],
            'recordsTotal' => 5,
            'recordsFiltered' => 1,
        ]);
    }

    public function testItShouldNotReturnUsersPaginateWhenUserIsNotAuthenticated(): void
    {
        $result = $this->get('/api/users');

        $result->assertRedirect();
    }
}