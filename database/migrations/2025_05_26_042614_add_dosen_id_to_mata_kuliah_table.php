<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('mata_kuliah', function (Blueprint $table) {
        // Tambahkan kolom
        $table->unsignedBigInteger('dosen_id')->nullable()->after('sks');
        
        // Tambahkan foreign key
        $table->foreign('dosen_id')
              ->references('id')
              ->on('dosens')
              ->onDelete('set null');
    });
}
    public function down()
    {
        Schema::table('mata_kuliah', function (Blueprint $table) {
            $table->dropForeign(['dosen_id']);
            $table->dropColumn('dosen_id');
        });
    }
};