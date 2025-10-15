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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['kader', 'bidan', 'dokter', 'admin'])->default('kader')->after('email');
            $table->foreignId('posyandu_id')->nullable()->constrained('posyandus')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['posyandu_id']);
            $table->dropColumn(['role', 'posyandu_id']);
        });
    }
};
