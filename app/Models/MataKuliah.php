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

    public function presences()
    {
        return $this->hasMany(Presence::class, 'matkul_id');
    }

    public function mahasiswas()
    {
        return $this->belongsToMany(Mahasiswa::class, 'mahasiswa_matkul', 'matkul_id', 'mahasiswa_id')
            ->withTimestamps();
    }
}