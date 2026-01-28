<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest1;

class SyncDownloadZipRequest extends FormRequest1
{
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:zip',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'file is required',
            'file.string' => 'file is to be string',
            'file.mime' => 'file is not zip',
        ];
    }

    public function authorize(): bool
    {
        return parent::authorize();
    }


}