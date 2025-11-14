<?php

namespace app\formRequest;

use AllowDynamicProperties;
use app\formRequest\baseFormRequests\FormRequest;


#[AllowDynamicProperties] class StoreProductMainImageRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function authorize(): bool
    {
        return isset($this->phpSession)
        && $this->phpSession === session_id();
    }

    public function rules(): array
    {
        return [
            'productId' => 'required|string',
            'file.*' => 'max:5000|image|mimes:jpeg,jpg,gif,png',
        ];
    }

    public function all($keys = null): array
    {
        $post  = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $files = $_FILES;
        return array_merge($post, $files);
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