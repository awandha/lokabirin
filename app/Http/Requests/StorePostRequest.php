<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'slug'    => 'required|string|unique:posts,slug',
        ];
    }
}
