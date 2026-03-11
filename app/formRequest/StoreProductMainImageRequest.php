<?php

namespace app\formRequest;

//use app\formRequest\baseFormRequests\FormRequest;
use app\formRequest\baseFormRequests\FormRequest2;

class StoreProductMainImageRequest extends FormRequest2
{
    public function __construct()
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'productId' => 'required|string',
            'file' => 'max:30000|image|mimes:jpeg,jpg,gif,png,webp',
        ];
    }

    public function messages(): array
    {
        return [
            'productId.required' => 'отсутствует поле productId',
            'productId.string' => 'поле productId должно быть строкой',

            'file.max' => 'размер файла больше 12',
            'file.mimes' => 'тип файла не тот',
            'file.image' => 'кто сказал, что это картинка!...',
        ];
    }


}