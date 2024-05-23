<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataLapangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Set true jika Anda memiliki middleware autentikasi yang sesuai
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tahun' => 'required|integer',
            'luasan' => 'required|numeric',
            'pantai_id' => 'required|exists:pantais,id', // Memastikan bahwa pantai_id ada di tabel pantai
        ];
    }
}
