<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, UseTestDatabase, RefreshDatabase;

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Set the database connection to use the test database
        $app['config']->set('database.connections.mysql.database', 'laravel_test');
        
        // Set the session driver to file
        $app['config']->set('session.driver', 'file');
        
        // Disable CSRF protection for all tests
        $app->instance(VerifyCsrfToken::class, new class extends VerifyCsrfToken {
            protected $except = ['*'];
        });
        
        // Remove CSRF middleware from all routes
        $this->withoutMiddleware(VerifyCsrfToken::class);
        
        // Disable middleware for all routes
        Route::middleware([]);
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Start the session
        Session::start();
        
        // Run migrations for the test database
        $this->artisan('migrate:fresh');
    }
}
