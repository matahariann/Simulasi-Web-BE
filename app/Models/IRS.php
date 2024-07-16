<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IRS extends Model
{
    use HasFactory;

    protected $table = 'irss';

    protected $fillable = [
        'semester',
        'jumlahSKS',
        'scanIRS',
        'aproval',
        'nim_mhs',
    ];

    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mhs', 'nim');
    }
}
