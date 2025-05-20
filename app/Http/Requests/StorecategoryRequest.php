<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorecategoryRequest extends FormRequest
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
            'name' => "required|unique:categories,name,except,id",
            'website' => 'nullable|url',
            'facebook' => 'nullable|string|max:255',
            'telegram' => 'nullable|string|max:255',
            'course_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
