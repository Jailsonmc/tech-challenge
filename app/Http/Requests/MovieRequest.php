<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'year' => 'required|string',
            'synopsis' => 'required|string',
            'runtime' => 'required|numeric',
            'released_at' => 'required|string',
            'cost' => 'required|numeric', 
        ];
    }
}
