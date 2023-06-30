<?php

namespace Feature\API\User;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Models\UserFabricator;

class PaginateTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $refresh = true;
    protected $namespace = 'App';

    public function testItShouldReturnUsersPaginate(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $user = $userFabricator->create();

        $result = $this->get('/api/users');

        $result->assertOK();
        $result->assertJSONExact([
            'data' => [
                [
                    'id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'mobile' => $user['mobile'],
                    'username' => $user['username'],
                ]
            ],
            'recordsTotal' => 1,
            'recordsFiltered' => 1,
        ]);
    }

    public function testItShouldReturnUsersPaginateWithCustomPerPage(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $userFabricator->create(10);

        $params = [
            'length' => 5,
        ];

        $result = $this->get('/api/users', $params);

        $data = json_decode($result->getJSON(), true);

        $result->assertOK();
        $this->assertCount(5, $data['data']);
    }

    public function testItShouldReturnUsersPaginateSearchingByFirstName(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $userFabricator->create(4);

        $user = $userFabricator->setOverrides([
            'first_name' => 'Lucas',
        ])->create();

        $params = [
            'search' => [
                'value' => 'lucas',
            ],
        ];

        $result = $this->get('/api/users', $params);

        $result->assertOK();
        $result->assertJSONExact([
            'data' => [
                [
                    'id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'mobile' => $user['mobile'],
                    'username' => $user['username'],
                ]
            ],
            'recordsTotal' => 5,
            'recordsFiltered' => 1,
        ]);
    }

    public function testItShouldReturnUsersPaginateSearchingByLastName(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $userFabricator->create(4);

        $user = $userFabricator->setOverrides([
            'last_name' => 'Sauro',
        ])->create();

        $params = [
            'search' => [
                'value' => 'sauro',
            ],
        ];

        $result = $this->get('/api/users', $params);

        $result->assertOK();
        $result->assertJSONExact([
            'data' => [
                [
                    'id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'mobile' => $user['mobile'],
                    'username' => $user['username'],
                ]
            ],
            'recordsTotal' => 5,
            'recordsFiltered' => 1,
        ]);
    }

    public function testItShouldReturnUsersPaginateSearchingByUsername(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $userFabricator->create(4);

        $user = $userFabricator->setOverrides([
            'username' => 'datingPx',
        ])->create();

        $params = [
            'search' => [
                'value' => 'datingpx',
            ],
        ];

        $result = $this->get('/api/users', $params);

        $result->assertOK();
        $result->assertJSONExact([
            'data' => [
                [
                    'id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'mobile' => $user['mobile'],
                    'username' => $user['username'],
                ]
            ],
            'recordsTotal' => 5,
            'recordsFiltered' => 1,
        ]);
    }

    public function testItShouldReturnUsersPaginateSearchingByEmail(): void
    {
        $userFabricator = new Fabricator(UserFabricator::class);
        $userFabricator->create(4);

        $user = $userFabricator->setOverrides([
            'email' => 'lucas@gmail.com',
        ])->create();

        $params = [
            'search' => [
                'value' => 'lucas@gmail.com',
            ],
        ];

        $result = $this->get('/api/users', $params);

        $result->assertOK();
        $result->assertJSONExact([
            'data' => [
                [
                    'id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'mobile' => $user['mobile'],
                    'username' => $user['username'],
                ]
            ],
            'recordsTotal' => 5,
            'recordsFiltered' => 1,
        ]);
    }
}