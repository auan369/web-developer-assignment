<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Tests\UseTestDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshTestDatabase;
    use UseTestDatabase;

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Force the database connection to use the test database
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing.database', 'laravel_test');
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure we're using the test database
        $this->useTestDatabase();
    }
}
