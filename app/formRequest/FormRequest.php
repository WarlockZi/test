<?php

namespace app\formRequest;


use app\service\AuthService\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use JetBrains\PhpStorm\NoReturn;

abstract class FormRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
    }

    abstract public function rules(): array;

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        $req = ['phpSession' => $this->json('phpSession')];
        if (!Auth::validatePphSession($req)) throw new \Exception('плохой token');
        return true;
    }

    public function prepareForValidation(): void
    {
        if ($_FILES) {
            $uploadedFiles = [];
            foreach ($_FILES as $fileData) {
                $uploadedFiles[] = new UploadedFile(
                    $fileData['tmp_name'],          // Temporary file path
                    $fileData['name'],              // Original name
                    $fileData['type'],             // MIME type
                    $fileData['error'],            // Error code
                    true                           // Test mode (set to false in production)
                );
                $_FILES['file']  = $uploadedFiles;
            }
        }

    }

    public function validate(): array
    {
        if (!$this->authorize()) {
            throw new \Exception('Unauthorized', 403);
        }

        $this->prepareForValidation();

        $validator = $this->createValidator();

        if ($validator->fails()) {
            $errors = $validator->errors();
            $this->throwValidationException($validator);
        }
        return $validator->getData();

    }

    #[NoReturn] protected function throwValidationException($validator): void
    {
        response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);
    }

    protected function createValidator(): Validator
    {
        $factory = new Factory(
            new Translator(
                new ArrayLoader(), 'ru'
            )
        );

        return $factory->make(
            $this->all(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );
    }

    private function UploadedFile2Array(UploadedFile $file): array
    {
        return [
            'originalName' => $file->getClientOriginalName(),
            'mimeType' => $file->getClientMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'error' => $file->getError(),
            'path' => $file->getPathname(),
        ];
    }

    public function after(): array
    {
        $arr = [];
        if ($_FILES) {
            foreach ($_FILES['file'] as $fileData) {
                $arr[] = $this->UploadedFile2Array($fileData);
            }
        }
        return $arr;
    }

    public function validated(): array
    {
        $this->authorize();
        $this->prepareForValidation();
        $validator = $this->createValidator();


        $d = $validator->validate();

        return $this->after();
    }

}