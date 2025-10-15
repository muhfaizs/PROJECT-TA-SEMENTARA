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
        Schema::create('anaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_id')->constrained('ibus')->cascadeOnDelete();
            $table->string('nik', 16)->nullable()->unique();
            $table->string('nama', 100);
            $table->date('tgl_lahir');
            $table->enum('jk', ['L', 'P']);
            $table->decimal('bb_lahir', 5, 2)->nullable()->comment('Berat badan lahir (kg)');
            $table->decimal('tb_lahir', 5, 2)->nullable()->comment('Tinggi badan lahir (cm)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anaks');
    }
};
