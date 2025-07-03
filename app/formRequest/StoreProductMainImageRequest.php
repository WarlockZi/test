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
            'post.productId' => 'string',
            'files.file' => 'max:13|image|mimes:jpeg,png,jpg,gif',
        ];
    }

    public function all($keys = null): array
    {
        if (!$keys) {
            return array_merge($_POST, $_FILES);
        }
        $all  = parent::all();
        $only = [];

        foreach ($keys as $key) {
            if (in_array($key, $all)) {
                $only[$key] = $all[$key];
            }
        }

//        return[
//                'post.productId' => $_POST['productId'],
//                'file' => $_FILES['file'],
//            ];
    }

    public function messages(): array
    {
        return [
            'post.productId.required' => 'отсутствует поле productId',
            'post.productId.string' => 'поле productId должно быть строкой',

            'files.file.max' => 'размер файла больше 13',
            'files.file.mimes' => 'тип файла не тот',
            'files.file.image' => 'кто сказал, что это картинка!...',
        ];
    }


}