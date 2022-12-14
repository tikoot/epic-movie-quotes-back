<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    /*
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'quote_en' => 'required|regex:/^[a-z0-9_. ]+$/',
            'quote_ka' => 'required|regex:/^[ა-ჰ_. ]+$/',
            'movie_id' => 'required',

        ];
    }
}
