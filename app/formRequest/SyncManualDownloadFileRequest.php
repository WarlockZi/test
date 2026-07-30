<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest1;

class SyncManualDownloadFileRequest extends FormRequest1
{
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimetypes:application/xml,text/xml',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'file is required',
            'file.string' => 'file is to be string',
            'file.mimes' => 'file is not xml',
        ];
    }

    public function authorize(): bool
    {
        return parent::authorize();
    }


}