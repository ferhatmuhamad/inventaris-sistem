<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Month extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'month';
    public $timestamps = true;

    protected $fillable = [
        'nama_bulan', 'active'
    ];

    protected $hidden = [];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_month', 'id');
    }
}
