<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest2;

class ChangePasswordRequest extends FormRequest2
{
    public function __construct( )
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
         ];
    }


    public function messages(): array
    {
        return [
            'old_password.required' => 'The old_password field is required.',
            'old_password.string' => 'The old_password must be a string.',
            'old_password.min' => 'The old_password must be at least 6 characters.',

            'new_password.required' => 'The new_password field is required.',
            'new_password.string' => 'The new_password must be a string.',
            'new_password.min' => 'The new_password must be at least 6 characters.',
        ];
    }
}