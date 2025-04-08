<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\UseTestDatabase;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
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
        
        // Force the session driver to file
        $app['config']->set('session.driver', 'file');
        
        // Disable CSRF protection for all tests
        $app->instance(VerifyCsrfToken::class, new class extends VerifyCsrfToken {
            protected $except = ['*'];
        });
        
        // Remove CSRF middleware from all routes
        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure we're using the test database
        $this->useTestDatabase();
        
        // Start the session
        Session::start();
        
        // Disable CSRF middleware for all routes
        Route::middleware([])->group(function () {
            // Your routes will be registered here
        });
    }
}
