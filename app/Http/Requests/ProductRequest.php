<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [
            // 'kode' => 'required|max:255',
            // 'id_kategori' => 'required|integer|exists:product,id',
            // 'nama_produk' => 'required|max:255',
            // 'spesifikasi' => 'required|max:255',
            // 'stok' => 'required|integer',
            // 'letak' => 'required|max:255',
            // 'supplier' => 'required|max:255',
            // 'barang_masuk' => 'date',
            // 'harga_jual' => 'integer',
            // 'harga_beli' => 'required|integer',
            // 'photo' => 'required|image',
            // 'kodeqr' => 'image',
        ];
    }
}
