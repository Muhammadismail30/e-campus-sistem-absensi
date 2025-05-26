<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';
    protected $fillable = ['kode', 'nama', 'sks', 'dosen_id'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class)->with('user');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function absensi()
    // {
    //     return $this->hasMany(Absensi::class);
    // }

    // public function materi()
    // {
    //     return $this->hasMany(Materi::class);
    // }

    // public function tugas()
    // {
    //     return $this->hasMany(Tugas::class);
    // }

    // public function kelas()
    // {
    //     return $this->belongsToMany(Kelas::class, 'kelas_matakuliah');
    // }
    // public function kelas()
    // {
    //     return $this->hasMany(Kelas::class);
    // }
}
