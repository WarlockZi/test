<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest2;
use app\service\AuthService\AuthService;

class ProductFilterReport extends FormRequest2
{
    public function __construct()
    {
        parent::__construct();
    }
    public function authorize(): bool
    {
        return !!AuthService::getUser();
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
//    public function after(): array{
//        return $this->all()['changedFilters'];
//    }
}