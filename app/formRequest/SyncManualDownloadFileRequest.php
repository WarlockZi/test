<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest1;
use app\formRequest\baseFormRequests\FormRequest2;

class SyncManualDownloadFileRequest extends FormRequest2
{
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimetypes:application/xml,text/xml',
                function ($attribute, $value, $fail) {
                    $filename = pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME);

                    if (!str_starts_with($filename, 'offer') && !str_starts_with($filename, 'import')) {
                        $fail('Название должно быть "offer" или "import" .');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'file is required',
            'file.file' => 'file должен быть файлом',
            'file.mimetypes' => 'file должен быть xml',
        ];
    }

    public function authorize(): bool
    {
        return parent::authorize();
    }


}