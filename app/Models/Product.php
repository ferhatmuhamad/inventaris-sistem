<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product';

    protected $fillable = [
        'kode', 'id_kategori', 'nama_produk', 'spesifikasi', 'stok', 'letak', 'supplier', 'barang_masuk', 'harga_jual', 'harga_beli', 'photo', 'kodeqr'
    ];

    protected $hidden = [];

    public function productcategory()
    {
        return $this->belongsTo(ProductCategory::class, 'id_kategori', 'id');
    }

    public function getPhotoAttribute($value)
    {
        return url('storage/' . $value);
    }

    // public function details()
    // {
    //     return $this->hasMany(ProductDetail::class)
    // }
}
