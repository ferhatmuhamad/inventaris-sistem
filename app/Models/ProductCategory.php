<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_category';

    protected $fillable = [
        'nama_kategori','user_name'
    ];

    protected $hidden = [];

    public function products()
    {
        // return $this->hasMany(Product::class, 'id_kategori');
    }

    // public function product_category()
    // {
    //     return $this->belongsTo(Product::class, 'id_kategori', 'id');
    // }
}
