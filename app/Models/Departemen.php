<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemens';
    protected $primaryKey = 'kodeDepartemen';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kodeDepartemen',
        'namaDepartemen',
        'email',
        'user_id'
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
