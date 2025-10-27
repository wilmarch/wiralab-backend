<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name (e.g., "Alat Ukur", "Chemicals")
            $table->string('slug')->unique();
            $table->enum('category_type', ['product', 'application']); // Type of category
            $table->timestamps();

            // Ensure name is unique *within* its type
            $table->unique(['name', 'category_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};