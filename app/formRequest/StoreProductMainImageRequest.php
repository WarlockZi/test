<?php

namespace app\formRequest;

use AllowDynamicProperties;
use HttpResponseException;
use Illuminate\Validation\Validator;
use JetBrains\PhpStorm\NoReturn;


#[AllowDynamicProperties] class StoreProductMainImageRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'post.productId' => 'required|string',
            'files.file' => [
                'required',
//                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:3000024',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
//            'size' => 'user size',
//            'productId' => 'product_id',
        ];
    }
    public function messages(): array
    {
        return [
            'file.max' => 'размер файла больше 10',
            'file.mimes' => 'тип файла не тот',
        ];
    }
    #[NoReturn] protected function failedValidation(Validator $validator): void
    {
        response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);
    }
}