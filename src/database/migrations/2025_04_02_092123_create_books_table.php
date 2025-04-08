<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id'); // Use increments for primary key in Laravel 6
            $table->string('title');
            $table->string('author');
            $table->timestamps(); // Adds created_at & updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
}
