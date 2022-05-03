<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QRCodeModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'qrcode';
    public $timestamps = false;

    protected $fillable = [
        'qrcode', 'path_qrcode', 'path_img'
    ];
}
