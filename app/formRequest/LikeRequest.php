<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest;

class LikeRequest extends FormRequest
{
    public function __construct(
        protected $allowedFields = ['attach', 'fields', 'relation', 'id','phpSession']
    )
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'fields' => 'required',
            'relation' => 'required',
            'phpSession' => 'required|string',
        ];
    }

    public function all($keys = null): array
    {
        return [
            'attach' => $this->json('attach'),
            'fields' => $this->json('fields'),
            'id' => $this->json('id'),
            'relation' => $this->json('relation'),
            'phpSession' => $this->json('phpSession'),
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }

}