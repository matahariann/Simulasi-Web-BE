<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    use HasFactory;

    protected $table = 'khss';

    protected $fillable = [
        'semester',
        'sksSemester',
        'ipSemester',
        'sksKumulatif',
        'ipKumulatif',
        'scanKHS',
        'approval',
        'nim_mhs',
    ];

    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mhs', 'nim');
    }
}
