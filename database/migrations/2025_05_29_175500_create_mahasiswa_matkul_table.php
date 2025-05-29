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
        Schema::create('mahasiswa_matkul', function (Blueprint $table) {
            $table->unsignedBigInteger('matkul_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->timestamps();
            
            $table->primary(['matkul_id', 'mahasiswa_id']);
            
            $table->foreign('matkul_id')
                  ->references('id')
                  ->on('mata_kuliah')
                  ->onDelete('cascade');
                  
            $table->foreign('mahasiswa_id')
                  ->references('id')
                  ->on('mahasiswas')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_matkul');
    }
};
