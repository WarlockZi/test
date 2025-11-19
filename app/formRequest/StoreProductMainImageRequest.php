<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest;

 class StoreProductMainImageRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'productId' => 'required|string',
            'file.*' => 'max:15000|image|mimes:jpeg,jpg,gif,png,webp',
        ];
    }

    public function all($keys = null): array
    {
        $post  = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $file = $_FILES['file'];
        return ['post'=>$post, 'file'=>$file];
    }

    public function messages(): array
    {
        return [
            'post.productId.required' => 'отсутствует поле productId',
            'post.productId.string' => 'поле productId должно быть строкой',

            'file.max' => 'размер файла больше 12',
            'file.mimes' => 'тип файла не тот',
            'file.image' => 'кто сказал, что это картинка!...',
        ];
    }


}