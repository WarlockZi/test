<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest1;

class CompareRequest extends FormRequest1
{
    public function __construct(
    )
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'fields' => 'required',
            'phpSession' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'fields.required' => 'Требуется поле fields',
            'phpSession.required' => 'Требуется поле phpSession',
            'phpSession.string' => 'phpSession должно быть строкой',
        ];
    }
    public function authorize(): bool
    {
        return !empty($this->json('phpSession'));
    }
}