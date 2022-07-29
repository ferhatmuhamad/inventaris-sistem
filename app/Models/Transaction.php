<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Periode;
use App\Models\Month;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transaction';
    public $timestamps = true;

    protected $fillable = [
        'id_product', 'date', 'stock', 'type', 'check', 'status_bill', 'bill', 'id_customer', 'id_supplier', 'id_warehouse', 'id_periode', 'id_month','user_name'
    ];

    protected $hidden = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'id_kategori', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'id_warehouse', 'id');
    }

    public function total_stock()
    {
        $periode = Periode::where('active', 'Y')->get();
        $month = Month::where('active', 'Y')->get();
        if ($periode->count() == 1 && $month->count() == 0) {
            $pr = 0;
        } else if($periode->count() == 1 && $month->count() == 1) {
            $pr = $periode->first()->id;
            $mt = $month->first()->id;
        }else {
            $pr = 0;
        }
        $sql = DB::table('transaction')->select(DB::raw('SUM(stock) as total_stock'))->where('id_periode', $pr)
        ->where('id_month', $mt)
        ->where('id_product', $this->id_product)
        ->where('check', 'S')
        ->where('status_bill', '!=','F')
        ->where('deleted_at', null)->first();

        // dd($sql);

        return $sql->total_stock;
    }

    public function type_stock($type)
    {
        $periode = Periode::where('active', 'Y')->get();
        if ($periode->count() == 1) {
            $pr = $periode->first->id;
        } else {
            $pr = 0;
        }
        $sql = DB::table('transaction')->select(DB::raw('SUM(stock) as total_stock'))->where('id_periode', $pr)->where('id_product', $this->id_product)->where('type', $type)->first();
        return $sql->type_stock;
    }

}
