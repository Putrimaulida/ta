<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PantaiRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama_pantai' => 'required|string|max:255',
            'lokasi_pantai' => 'required|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ];
    }
}
