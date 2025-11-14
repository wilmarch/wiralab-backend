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
        Schema::table('posts', function (Blueprint $table) {
            // Tambahkan foreign key
            $table->foreignId('blog_category_id')
                  ->nullable() // Boleh kosong
                  ->after('post_type') // Posisi di database (rapi)
                  ->constrained('blog_categories') // Terhubung ke tabel 'blog_categories'
                  ->onDelete('set null'); // Jika Kategori dihapus, kolom ini jadi NULL (Post tidak ikut terhapus)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Hapus relasi dan kolom jika di-rollback
            $table->dropForeign(['blog_category_id']);
            $table->dropColumn('blog_category_id');
        });
    }
};