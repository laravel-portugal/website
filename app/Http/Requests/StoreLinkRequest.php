<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreLinkRequest extends FormRequest
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
        // Meta and Title should go with google standards for SEO
        // @see https://www.stanventures.com/blog/meta-title-length-meta-description-length/
        return [
            'url' => [
                'required',
                'url',
                'active_url',
                'unique:links,url',
            ],
            'title' => [
                'required',
                'min:10',
                'max:'.config('laravel-portugal.links.title_max_size'),
            ],
            'description' => [
                'required',
                'min:30',
                'max:'.config('laravel-portugal.links.description_max_size'),
            ],
            'cover_image' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:'.config('laravel-portugal.links.cover_image_max_size'),
            ],
            'tags.*' => [
                'required',
                'exists:tags,id',
            ],
            'tags' => [
                'required',
                'array',
                'between:1,4',
            ],
            'url_hash' => [
                'required',
                'unique:links,url_hash',
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'ip_address' => $this->getClientIp(),
            'url_hash' => hash_url($this->input('url') ?? ''),
        ]);
    }

    /**
     * Configure the validator instance.
     *
     * @param Validator $validator
     *
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            /** @var Validator $validator */
            if ($validator->errors()->has('url_hash')) {
                $validator->errors()->add('url', trans('validation.unique', ['attribute' => trans('app.links.url')]));
            }

            if ($validator->errors()->has('tags.*')) {
                $validator->errors()->add('tags', trans('validation.tags-invalid'));
            }
        });
    }
}
