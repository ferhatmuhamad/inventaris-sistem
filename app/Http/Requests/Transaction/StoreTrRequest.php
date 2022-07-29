<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Transaction;
use App\Models\Periode;

class StoreTrRequest extends FormRequest
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
        $periode = Periode::where('active','Y')->get();
        if ($periode->count() == 1) {
            $periode = $periode->first();
        } else {
            return redirect('dashboard');
        }

        $data['parse'] = Transaction::where('type','SO')->where('id_periode',$periode->id)->get();
        if ($data['parse']->count() == 0) {
            return redirect('dashboard');
        } else {
            foreach($data['parse'] as $item){
                $items[] = $item->product->id;
            }
        }
        $product = implode(',',$items);

        $rules = [
            'date'      => 'required|date_format:Y-m-d',
            'type'      => 'required|in:S,B'
        ];

        foreach($this->request->get('id_product') as $key => $value)
        {
            $rules['product_id.'.$key] = 'required|in:'.$product; // you can set rules for all the array items
        }

        foreach($this->request->get('stock') as $key => $value)
        {
            $rules['stock.'.$key] = 'required|numeric';
        }
        return $rules;
    }
}
