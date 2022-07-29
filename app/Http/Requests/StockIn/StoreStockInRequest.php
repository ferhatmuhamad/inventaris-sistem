<?php

namespace App\Http\Requests\StockIn;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Product;
use App\Models\Periode;
use App\Models\Transaction;

class StoreStockInRequest extends FormRequest
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
            return redirect('/');
        }

        $data['parse'] = Transaction::where('type', 'SO')->where('id_periode', $periode->id)->get();
        if ($data['parse']->count() == 0) {
            return redirect('/');
        } else {
            foreach($data['parse'] as $item){
                $items[] = $item->product->id;
            }
        }

        $product = implode(',', $items);

        $rules = [
            'date'  => 'required|date_format:Y-m-d',
            'type'  => 'required|in:S,B'
        ];

        foreach($this->request->get('id_product') as $key => $value)
        {
            $rules['id_product.'.$key] = 'required|in:'.$product;
        }

        foreach ($this->request->get('stock') as $key => $value) {
            $rules['stock.'.$key] = 'required|numeric';
        }
        return $rules;
    }
}
