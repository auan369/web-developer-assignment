<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

trait UseTestDatabase
{
    /**
     * Set up the test database connection.
     *
     * @return void
     */
    protected function useTestDatabase(): void
    {
        // Force the database connection to use the test database
        Config::set('database.default', 'testing');
        Config::set('database.connections.testing.database', 'laravel_test');
        
        // Force the session driver to file
        Config::set('session.driver', 'file');
        
        // Set environment variables directly
        putenv('DB_CONNECTION=testing');
        putenv('DB_DATABASE=laravel_test');
        putenv('SESSION_DRIVER=file');
        
        // Force the database connection to use the test database
        DB::purge('testing');
        DB::reconnect('testing');
        
        // Start the session
        Session::start();
        
        // Verify we're using the test database
        $this->verifyTestDatabase();
    }
    
    /**
     * Verify that we're using the test database
     */
    protected function verifyTestDatabase(): void
    {
        // Get the current database name
        $currentDatabase = DB::connection()->getDatabaseName();
        
        // Check if we're using the test database
        if ($currentDatabase !== 'laravel_test') {
            throw new \RuntimeException(
                "Tests must use the 'laravel_test' database. Current database: {$currentDatabase}"
            );
        }
        
        // Log the database being used (for debugging)
        echo "Using test database: {$currentDatabase}\n";
    }
} 