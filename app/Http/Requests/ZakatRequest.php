<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZakatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'region'      => ['required','string','max:100'],
            'jumlah_hari' => ['nullable','integer','min:1','max:365'],
        ];
    }

    public function messages(): array
    {
        return [
            'region.required' => 'Wilayah/Region wajib diisi.',
        ];
    }
}
