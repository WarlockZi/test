<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest2;
use app\service\AuthService\AuthService;

class StoreProductMainImageRequest extends FormRequest2
{
    public function __construct()
    {
        parent::__construct();
    }
    public function authorize(): bool
    {
        $user = AuthService::userIsAdmin();
        return (bool)$user;
    }

    public function rules(): array
    {
        return [
            'productSId' => 'required|string',
            'file' => 'max:3000000|image|mimes:jpeg,jpg,gif,png,webp',
        ];
    }

    public function messages(): array
    {
        return [
            'productSId.required' => 'отсутствует поле productId',
            'productSId.string' => 'поле productId должно быть строкой',

            'file.max' => 'размер файла больше 1mb',
            'file.mimes' => 'тип файла не тот',
            'file.image' => 'кто сказал, что это картинка!...',
        ];
    }


}