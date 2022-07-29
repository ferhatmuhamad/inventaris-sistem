<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periode extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'periode';
    public $timestamps = true;

    protected $fillable = [
        'nama_periode', 'active','user_name'
    ];

    protected $hidden = [];
}
