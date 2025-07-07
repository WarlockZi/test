<?php

namespace app\formRequest;

use AllowDynamicProperties;


#[AllowDynamicProperties] class StoreProductMainImageRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
    }



    public function rules(): array
    {
        return [
            'productId' => 'required|string',
            'file.*' => 'max:12000|image|mimes:jpeg,jpg,gif',
        ];
    }

    public function all($keys = null): array
    {
            return array_merge($_POST, $_FILES);
    }

    public function messages(): array
    {
        return [
            'post.productId.required' => 'отсутствует поле productId',
            'post.productId.string' => 'поле productId должно быть строкой',

            'file.max' => 'размер файла больше 13',
            'file.mimes' => 'тип файла не тот',
            'file.image' => 'кто сказал, что это картинка!...',
        ];
    }


}