<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

trait UseTestDatabase
{
    /**
     * Ensure the test database is used.
     *
     * @return void
     */
    protected function useTestDatabase()
    {
        // Force the database connection to use the test database
        Config::set('database.default', 'testing');
        Config::set('database.connections.testing.database', 'laravel_test');
        
        // Reconnect to ensure we're using the test database
        DB::purge();
        DB::reconnect('testing');
        
        // Verify we're using the test database
        $this->verifyTestDatabase();
    }
    
    /**
     * Verify that we're using the test database
     */
    protected function verifyTestDatabase()
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