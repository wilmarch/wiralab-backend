<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('careers', function (Blueprint $table) {
            // 1. Tambahkan foreign key untuk Company
            // (pastikan 'id' di tabel 'companies' adalah bigint unsigned)
            $table->foreignId('company_id')
                  ->after('job_category_id') // Posisikan setelah kategori
                  ->constrained('companies')
                  ->onDelete('cascade'); // Jika perusahaan dihapus, lowongannya juga terhapus

            // 2. Tambahkan foreign key untuk Location
            $table->foreignId('location_id')
                  ->after('company_id') // Posisikan setelah company
                  ->constrained('locations')
                  ->onDelete('cascade');

            // 3. (Opsional) Hapus kolom string lama jika Anda membuatnya
            // $table->dropColumn(['company', 'location']); 
        });
    }

    public function down(): void
    {
        Schema::table('careers', function (Blueprint $table) {
            // Hapus relasi jika di-rollback
            $table->dropForeign(['company_id']);
            $table->dropForeign(['location_id']);
            $table->dropColumn(['company_id', 'location_id']);
        });
    }
};