<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    use HasFactory;

    protected $table = 'skripsis';
    
    protected $fillable = [
        'semester',
        'tanggalSidang',
        'dosenPembimbing',
        'scanSidang',
        'approval',
        'nim_mhs',
    ];

    protected $guarded = [];
    
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mhs', 'nim');
    }

}
