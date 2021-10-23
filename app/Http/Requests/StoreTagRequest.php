<?php

namespace App\Http\Requests;

use App\Types\TagColorType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreTagRequest extends FormRequest
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
            'name' => [
                'required',
                'unique:tags,name',
            ],
            'slug' => [
                'required',
                'unique:tags,slug',
            ],
            'description' => [
                'required',
                'min:5',
                'max:100',
            ],
            'color' => [
                'required',
                Rule::in(array_keys(TagColorType::toArray())),
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
            'slug' => \Str::slug($this->input('name') ?? ''),
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
            if ($validator->errors()->has('slug')) {
                $validator->errors()->add('name', trans('validation.unique', ['attribute' => trans('app.tags.slug')]));
            }
        });
    }
}
