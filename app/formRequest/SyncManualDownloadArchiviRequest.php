<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest1;

class SyncManualDownloadArchiviRequest extends FormRequest1
{
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:rar,zip',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'file is required',
            'file.string' => 'file is to be string',
            'file.mimes' => 'file is not rar or zip',
        ];
    }

    public function authorize(): bool
    {
        return parent::authorize();
    }


}