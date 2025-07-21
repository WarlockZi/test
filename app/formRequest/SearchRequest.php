<?php

namespace app\formRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use JetBrains\PhpStorm\NoReturn;


class SearchRequest extends FormRequest
{
    public function __construct(
        protected $allowedFields = ['text']
    )
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'text' => 'required',
        ];
    }

    public function all($keys = null): array
    {
        return [
            'text' => $this->json('text'),
        ];
    }

    public function messages(): array
    {
        return [
            'text.required' => 'The search field is required.',
        ];
    }
    #[NoReturn] protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }

}