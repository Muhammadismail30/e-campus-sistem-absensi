<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Presence extends Model
{
    protected $fillable = ['matkul_id', 'pertemuan_ke', 'topik', 'tanggal', 'is_active', 'barcode_token'];

    protected $casts = [
        'tanggal' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id'); // Sesuaikan foreign key dengan 'matkul_id'
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($presence) {
            $presence->barcode_token = Str::random(32);
        });
    }
}