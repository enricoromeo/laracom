<?php

namespace App\Shop\Stores\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateStoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:stores'],
            'cover' => ['required', 'file', 'image:png,jpeg,jpg,gif']
        ];
    }
}
