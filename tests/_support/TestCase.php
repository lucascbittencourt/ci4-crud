<?php

namespace Tests\Support;

use CodeIgniter\Shield\Test\AuthenticationTesting;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class TestCase extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use AuthenticationTesting;

    protected $migrate = true;
    protected $refresh = true;
    protected $namespace = null;

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->clearInsertCache();
        auth()->logout();
    }
}