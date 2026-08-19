<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest2;


class SearchRequest extends FormRequest2
{
        public function __construct()
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'text' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'text.string' => 'The search field is not string.',
        ];
    }
}