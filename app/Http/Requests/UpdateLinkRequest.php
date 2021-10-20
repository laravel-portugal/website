<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateLinkRequest extends StoreLinkRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:'.config('laravel-portugal.links.cover_image_max_size'),
            ],
            'url' => [
                'required',
                'url',
                'active_url',
                Rule::unique('links')->ignore($this->input('id')),
            ],
            'url_hash' => [
                'required',
                Rule::unique('links')->ignore($this->input('id')),
            ],
            'status' => ['exclude'],
        ]);
    }
}
