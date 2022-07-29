<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'supplier';

    protected $fillable = [
        'nama_supplier', 'alamat_supplier', 'email_supplier', 'telepon_supplier','user_name'
    ];

    protected $hidden = [];
}
