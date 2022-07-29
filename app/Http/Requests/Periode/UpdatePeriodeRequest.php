<?php

namespace App\Http\Requests\Periode;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodeRequest extends FormRequest
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
            'nama_periode' => 'required|max:255',
            'active' => 'required|in:N,Y'
        ];
    }
}
