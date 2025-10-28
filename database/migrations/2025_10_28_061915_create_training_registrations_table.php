<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_registrations', function (Blueprint $table) {
            $table->id();

            // Terhubung ke tabel 'trainings' (Tipe Training yang dipilih)
            $table->foreignId('training_id')->constrained('trainings')->onDelete('cascade');

            $table->string('name');
            $table->string('institution');
            $table->string('email');
            $table->string('phone');

            $table->boolean('is_contacted')->default(false); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_registrations');
    }
};