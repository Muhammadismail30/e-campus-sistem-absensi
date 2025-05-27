<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('materi', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->text('deskripsi')->nullable();
        $table->string('file')->nullable();
        $table->foreignId('mata_kuliah_id')->constrained('mata_kuliah')->onDelete('cascade');
        $table->timestamps();
    });
    
}
    public function down()
{
    Schema::dropIfExists('materi');
}

};
