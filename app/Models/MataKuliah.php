<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';
    protected $fillable = ['kode', 'nama', 'sks'];

    // public function kelas()
    // {
    //     return $this->hasMany(Kelas::class);
    // }
}
