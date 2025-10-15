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
        Schema::create('ibus', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('nama', 100);
            $table->date('tgl_lahir');
            $table->string('hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('posyandu_id')->constrained('posyandus');
            $table->date('hpht')->nullable()->comment('Hari Pertama Haid Terakhir');
            $table->date('tp')->nullable()->comment('Taksiran Persalinan');
            $table->unsignedSmallInteger('risk_score')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibus');
    }
};
