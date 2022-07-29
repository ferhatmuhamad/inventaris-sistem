<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'customer';

    protected $fillable = [
        'nama_customer', 'alamat_customer', 'email_customer', 'telepon_customer'
    ];

    protected $hidden = [];
}
