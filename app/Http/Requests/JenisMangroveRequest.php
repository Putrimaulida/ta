<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JenisMangroveRequest extends FormRequest
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
            'nama_keluarga_select' => 'nullable|string|max:255',
            'nama_keluarga_manual' => 'nullable|string|max:255',
            'nama_ilmiah' => 'required|string|max:255',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->nama_keluarga_select && !$this->nama_keluarga_manual) {
                $validator->errors()->add('nama_keluarga', 'You must fill either the existing family or the new family name.');
            }
            if ($this->nama_keluarga_select && $this->nama_keluarga_manual) {
                $validator->errors()->add('nama_keluarga', 'You cannot fill both fields.');
            }
        });
    }
}

