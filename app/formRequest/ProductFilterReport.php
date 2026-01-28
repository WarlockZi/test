<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest;

class ProductFilterReport extends FormRequest
{
    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $data = array_merge($data, $this->json()->all());

        return $data;
    }

    public function rules(): array
    {
        return [
            'changedFilters' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            'changedFilters.required' => 'changedFilters is to be required ',
            'changedFilters.array' => 'changedFilters is to be array',
        ];
    }
    public function after(): array{
        return $this->all()['changedFilters'];
    }
}