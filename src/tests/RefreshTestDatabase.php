<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase as BaseRefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

trait RefreshTestDatabase
{
    use BaseRefreshDatabase {
        BaseRefreshDatabase::refreshTestDatabase as parentRefreshTestDatabase;
    }

    /**
     * Refresh the test database.
     *
     * @return void
     */
    protected function refreshTestDatabase()
    {
        // Force the database connection to use the test database
        Config::set('database.default', 'testing');
        Config::set('database.connections.testing.database', 'laravel_test');
        
        // Reconnect to ensure we're using the test database
        DB::purge();
        DB::reconnect('testing');
        
        // Verify we're using the test database
        $currentDatabase = DB::connection()->getDatabaseName();
        if ($currentDatabase !== 'laravel_test') {
            throw new \RuntimeException(
                "Tests must use the 'laravel_test' database. Current database: {$currentDatabase}"
            );
        }
        
        // Call the parent method to refresh the test database
        $this->parentRefreshTestDatabase();
    }
} 