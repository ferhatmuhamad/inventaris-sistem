<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'warehouse';

    protected $fillable = [
        'nama_gudang', 'alamat_gudang','user_name'
    ];

    protected $hidden = [];
}
