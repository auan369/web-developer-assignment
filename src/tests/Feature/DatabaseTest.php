<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Clean up any leftover temp_table
        Schema::dropIfExists('temp_table');
    }

    protected function tearDown(): void
    {
        // Clean up any leftover temp_table
        Schema::dropIfExists('temp_table');
        parent::tearDown();
    }

    /**
     * Test that we're connecting to the test database during tests.
     *
     * @return void
     */
    public function testDatabaseConnection()
    {
        // Explicitly use the testing connection
        $databaseName = DB::connection('testing')->getDatabaseName();
        
        // Assert that we're using the test database
        $this->assertEquals('laravel_test', $databaseName, 
            "Tests should be running on the 'laravel_test' database, but they're running on '$databaseName'");
    }

    /**
     * Test that we can perform basic database operations.
     *
     * @return void
     */
    public function testBasicDatabaseOperations()
    {
        // Use the testing connection
        $connection = DB::connection('testing');
        
        // Create a simple table
        $connection->statement('CREATE TABLE IF NOT EXISTS test_table (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255))');
        
        // Insert a record
        $connection->table('test_table')->insert(['name' => 'Test Record']);
        
        // Retrieve the record
        $record = $connection->table('test_table')->where('name', 'Test Record')->first();
        
        // Assert the record exists
        $this->assertNotNull($record);
        $this->assertEquals('Test Record', $record->name);
        
        // Clean up - drop the table
        $connection->statement('DROP TABLE IF EXISTS test_table');
    }

    /**
     * Test that we're using the test database
     */
    public function testUsingTestDatabase()
    {
        // Get the current database name
        $currentDatabase = DB::connection()->getDatabaseName();
        
        // Assert we're using the test database
        $this->assertEquals('laravel_test', $currentDatabase);
    }
    
    /**
     * Test database transaction rollback
     */
    public function testDatabaseTransactionRollback()
    {
        // Ensure we're starting with a clean state
        Schema::dropIfExists('temp_table');
        
        // Create a transaction
        DB::beginTransaction();
        
        try {
            // Create a temporary table
            DB::statement('CREATE TABLE temp_table (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255))');
            
            // Insert a record
            DB::table('temp_table')->insert(['name' => 'Test Record']);
            
            // Verify the record exists
            $this->assertTrue(
                DB::table('temp_table')->where('name', 'Test Record')->exists(),
                'Record should exist within the transaction'
            );
        } finally {
            // Always roll back the transaction
            DB::rollBack();
        }
        
        // Clean up - drop the table
        Schema::dropIfExists('temp_table');
    }
    
    /**
     * Test that the temporary table doesn't exist after rollback
     */
    public function testTableDoesNotExistAfterRollback()
    {
        // Ensure we're starting with a clean state
        Schema::dropIfExists('temp_table');
        
        // Create a transaction
        DB::beginTransaction();
        
        try {
            // Create a temporary table
            DB::statement('CREATE TABLE temp_table (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255))');
            
            // Insert a record
            DB::table('temp_table')->insert(['name' => 'Test Record']);
            
            // Verify the table exists and has data
            $this->assertTrue(DB::table('temp_table')->where('name', 'Test Record')->exists(), 'Record should exist within transaction');
        } finally {
            // Always roll back the transaction
            DB::rollBack();
        }
        
        // Clean up - drop the table
        Schema::dropIfExists('temp_table');
        
        // The temp_table should not exist because we explicitly dropped it
        $this->assertFalse(
            Schema::hasTable('temp_table'),
            'Temporary table should not exist after cleanup'
        );
    }
}