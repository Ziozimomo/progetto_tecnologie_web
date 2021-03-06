<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewOrgRequest extends FormRequest
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
            'nomeutente' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'organizzazione' => 'required',
        ];
    }
}
