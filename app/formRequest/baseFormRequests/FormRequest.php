<?php

namespace app\formRequest\baseFormRequests;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use JetBrains\PhpStorm\NoReturn;


abstract class FormRequest extends Request
{
    protected $input = [];
    protected $errors = [];

    protected function getInputFromGlobal(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $rawInput    = file_get_contents('php://input');

        if (str_contains($contentType, 'application/json')) {
            return json_decode($rawInput, true) ?? [];
        } elseif (str_contains($contentType, 'application/x-www-form-urlencoded')) {
            parse_str($rawInput, $input);
            return $input;
        }
        $files = $this->convertFilesToUploadedFiles();
        return $_POST + $_GET + $files;
    }
    function convertFilesToUploadedFiles(): array
    {
        $uploadedFiles = [];

        foreach ($_FILES as $fieldName => $fileData) {
            if (is_array($fileData['name'])) {
                // Multiple files
                $uploadedFiles[$fieldName] = [];
                foreach ($fileData['name'] as $index => $name) {
                    $uploadedFiles[$fieldName][$index] = new UploadedFile(
                        $fileData['tmp_name'][$index],
                        $fileData['name'][$index],
                        $fileData['type'][$index],
                        $fileData['error'][$index],
                        true // test mode
                    );
                }
            } else {
                // Single file
                $uploadedFiles[$fieldName] = new UploadedFile(
                    $fileData['tmp_name'],
                    $fileData['name'],
                    $fileData['type'],
                    $fileData['error'],
                    true // test mode
                );
            }
        }

        return $uploadedFiles;
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

    public function prepareForValidation(): void
    {
    }

    public function authorize(): bool
    {
        return isset($this->input['phpSession'])
            && $this->input['phpSession'] === session_id();
    }

    /**
     * @throws Exception
     */
    public function validate(): array
    {
        $this->authorize();
        $this->prepareForValidation();

        $validator = $this->createValidator();

        if ($validator->fails()) {
            $errors = $validator->errors();
            $this->throwValidationException($validator);
        }
        return $this->after();
    }

    /**
     * @throws ValidationException
     */
    public function validated(): array
    {
        $this->authorize();
        $this->prepareForValidation();
        $validator = $this->createValidator();

        if (isset($this->input['phpSession'])) {
            unset($this->input['phpSession']);
        }

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            response()->json(['popup'=>$errors]);
        }

        return $validator->validated();
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

//        $data = $this->all();
        return $factory->make(
            $this->all(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );
    }

    /**
     * @throws Exception
     */
    public function safe(): object
    {
        return new class($this->validated()) {
            private $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function __get($name)
            {
                return $this->data[$name] ?? null;
            }

            public function all()
            {
                return $this->data;

            }

            public function only($keys): array
            {
                $keys = is_array($keys) ? $keys : func_get_args();
                return array_intersect_key($this->data, array_flip($keys));
            }

            public function except($keys): array
            {
                $keys = is_array($keys) ? $keys : func_get_args();
                return array_diff_key($this->data, array_flip($keys));
            }
        };
    }

}