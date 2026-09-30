<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->foreignId('koran_id')
                  ->after('id')
                  ->constrained('korans')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropForeign(['koran_id']);
            $table->dropColumn('koran_id');
        });
    }
};