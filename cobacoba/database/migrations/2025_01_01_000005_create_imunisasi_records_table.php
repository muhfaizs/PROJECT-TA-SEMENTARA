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
        Schema::create('imunisasi_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anaks')->cascadeOnDelete();
            $table->string('vaksin_code', 50)->comment('Kode vaksin: BCG, DPT1, DPT2, etc');
            $table->string('dosis', 20)->nullable()->comment('Dosis ke-');
            $table->date('given_at');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('imunisasi_records');
    }
};
