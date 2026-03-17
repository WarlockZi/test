<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest;
use app\formRequest\baseFormRequests\FormRequest2;
use app\service\AuthService\Auth;

class ProductFilterReport extends FormRequest2
{

    public function __construct()
    {
        parent::__construct();
    }
    public function authorize(): bool
    {
        $user = Auth::getUser();
        return !!$user;
    }
//    public function all($keys = null): array
//    {
//        $data = parent::all($keys);
////        $data = array_merge($data, $this->json()->all());
//        $content = json_decode($this->getContent());
//
//        return $content;
//    }

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