<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = ['mahasiswa_id', 'presence_id', 'waktu_absen', 'status'];

    protected $casts = [
        'waktu_absen' => 'datetime',
    ];
    
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    
    public function presence(): BelongsTo
    {
        return $this->belongsTo(Presence::class);
    }
}