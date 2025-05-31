<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswas';
    protected $fillable = ['user_id', 'nim'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function getNamaAttribute()
    {
        return $this->user->name;
    }

    public function mataKuliahs()
    {
        return $this->belongsToMany(MataKuliah::class, 'mahasiswa_matkul', 'mahasiswa_id', 'matkul_id');
    }
}