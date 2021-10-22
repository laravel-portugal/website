<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateTagRequest extends StoreTagRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'name' => [
                'required',
                Rule::unique('tags')->ignore($this->input('id')),
            ],
            'slug' => [
                'required',
                Rule::unique('tags')->ignore($this->input('id')),
            ],
        ]);
    }
}
