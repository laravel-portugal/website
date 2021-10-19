<?php

namespace App\Http\Requests;

use App\Types\LinkStatusType;
use Illuminate\Validation\Rule;

class UpdateLinkRequestForAdmin extends UpdateLinkRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'status' => [
                'required',
                Rule::in(array_keys(LinkStatusType::toArray()))
            ],
        ]);
    }
}
