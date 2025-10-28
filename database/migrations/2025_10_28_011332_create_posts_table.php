<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->string('slug')->unique(); 
            $table->longText('content');
            $table->enum('post_type', ['artikel', 'berita']); 
            $table->string('image_url')->nullable(); 
            $table->boolean('is_published')->default(false); 
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};