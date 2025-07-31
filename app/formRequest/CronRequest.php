<?php

namespace app\formRequest;

use app\service\AuthService\Auth;

class CronRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function authorize(): bool
    {
        return isConsole();
    }

    public function rules(): array
    {
        return [
        ];
    }

    public function all($keys = null): array
    {
        return [
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }

}