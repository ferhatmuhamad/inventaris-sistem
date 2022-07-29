<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockModel extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'product_stock';

    protected $fillable = [
        'id', 'id_product' , 'stock', 'total_stock', 'tanggal_masuk'
    ];

    protected $hidden = [];

    public function productstock()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }

}
