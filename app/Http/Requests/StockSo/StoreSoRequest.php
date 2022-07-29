<?php

namespace App\Http\Requests\StockSo;

use App\Models\Periode;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class StoreSoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $periode = Periode::where('active', 'Y')->get();
        if ($periode->count() == 1) {
            $periode = $periode->first();
        } else {
            $periode = 0;
        }

        $data['parse'] = Transaction::where('type', 'SO')->where('id_periode', $periode)->get();
        if ($data['parse']->count() == 0) {
            $data['product'] = Product::get();
        } else {
            foreach ($data['parse'] as $id) {
                $ids[] = $id->id;
            }
            $data['product'] = Product::WhereNotIn('id', $ids)->get();
        }

        // PRODUCT
        foreach ($data['product'] as $item) {
            $items[] = $item->id;
        }
        $product = implode(',',$items);

        // WAREHOUSE
        $data['warehouse'] = Warehouse::get();
        foreach($data['warehouse'] as $item){
            $items_2[] = $item->id;
        }
        $warehouse = implode(',',$items_2);

        return [
            'id_product'    => 'required|in:'.$product,
            'id_warehouse'  => 'required|in:'.$warehouse,
            'stock'         => 'required|min:0|numeric'
        ];
    }
}
