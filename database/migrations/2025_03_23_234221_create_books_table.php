<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('subtitle')->nullable();
            $table->longText('authors')->nullable();
            $table->longText('print_type')->nullable();
            $table->integer('page_count')->deafult(1);
            $table->longText('publisher')->nullable();
            $table->string('published_date')->nullable();
            $table->string('average_rating')->nullable(); 
            $table->longText('thumbnail')->nullable(); 
            $table->longText('language')->nullable(); 
            $table->longText('categories')->nullable();   
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
