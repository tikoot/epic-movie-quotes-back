<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    /*
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'movie_name_en' => 'required',
            'movie_name_ka' => 'required',
            'user_id' => 'required',
            'director_en' => 'required',
            'director_ka' => 'required',
            'description_en' => 'required',
            'description_ka' => 'required',
            'thumbnail' => 'required',
            'category' => 'required',
            'year' => 'required|integer',
            'budget' => 'required|integer',
        ];
    }
}
