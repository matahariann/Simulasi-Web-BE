<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama',
        'alamat',
        'kabKota',
        'provinsi',
        'angkatan',
        'jalurMasuk',
        'email',
        'noTelp',
        'status',
        'foto',
        'user_id',
        'dosenwali_nip',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dosenWali()
    {
        return $this->belongsTo(DosenWali::class, 'dosenwali_nip', 'nip');
    }

    public function skripsi()
    {
        return $this->hasMany(Skripsi::class, 'nim_mhs', 'nim');
    }

    public function khs()
    {
        return $this->hasMany(KHS::class, 'nim_mhs', 'nim');
    }

    public function pkl()
    {
        return $this->hasMany(PKL::class, 'nim_mhs', 'nim');
    }

    public function irs()
    {
        return $this->hasMany(IRS::class, 'nim_mhs', 'nim');
    }
}
