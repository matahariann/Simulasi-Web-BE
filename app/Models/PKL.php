<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKL extends Model
{
    use HasFactory;

    protected $table = 'pkls';

    protected $fillable = [
        'semester',
        'nilaiPKL',
        'instansi',
        'dosenPengampu',
        'scanPKL',
        'approval',
        'nim_mhs',
    ];

    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mhs', 'nim');
    }
}
