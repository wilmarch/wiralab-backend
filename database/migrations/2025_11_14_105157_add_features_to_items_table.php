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
        Schema::table('items', function (Blueprint $table) {
            // Kita taruh setelah 'image_url' agar rapi
            
            // 1. Untuk E-Katalog / Produk Unggulan di Beranda
            $table->boolean('is_featured')->default(false)->after('image_url');
            
            // 2. Untuk link Inaproc (E-Katalog)
            $table->string('inaproc_url')->nullable()->after('is_featured');
            
            // 3. Untuk file PDF Brosur
            $table->string('brosur_url')->nullable()->after('inaproc_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn(['is_featured', 'inaproc_url', 'brosur_url']);
        });
    }
};