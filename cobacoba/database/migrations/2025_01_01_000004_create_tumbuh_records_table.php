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
        Schema::create('tumbuh_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anaks')->cascadeOnDelete();
            $table->date('measured_at');
            $table->decimal('bb_kg', 5, 2)->comment('Berat badan (kg)');
            $table->decimal('tb_cm', 5, 2)->comment('Tinggi badan (cm)');
            $table->decimal('ll_cm', 5, 2)->nullable()->comment('Lingkar lengan (cm)');
            $table->enum('status_gizi', ['stunted', 'wasted', 'normal', 'overweight'])->nullable();
            $table->foreignId('posyandu_id')->constrained('posyandus');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->text('reject_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tumbuh_records');
    }
};
