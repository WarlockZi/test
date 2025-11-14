<?php

namespace app\formRequest\baseFormRequests;


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
    private array $validatedData;

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

    public function prepareForValidation(): void
    {
    }

    public function authorize(): bool
    {

        if (!Auth::validatePphSession($this->all())) throw new \Exception('плохой token');
        return true;
    }

    /**
     * @throws \Exception
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
        $validated = $this->after();

        return $validated;
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

//    public function after(): array
//    {
//        $arr = [];
//        if ($_FILES) {
//            foreach ($_FILES['file'] as $fileData) {
//                $arr[] = $this->UploadedFile2Array($fileData);
//            }
//        }
//
//        return $arr;
//    }

    /**
     * @throws \Exception
     */
    public function validated(): array
    {
        $this->authorize();
        $this->prepareForValidation();
        $validator = $this->createValidator();

        if ($validator->getData()['phpSession']) {
            $data = $validator->getData();
            unset($data['phpSession']);
        }
        $this->validatedData = $validator->getData();

        return $data;
    }

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

            public function only($keys)
            {
                $keys = is_array($keys) ? $keys : func_get_args();
                return array_intersect_key($this->data, array_flip($keys));
            }

            public function except($keys)
            {
                $keys = is_array($keys) ? $keys : func_get_args();
                return array_diff_key($this->data, array_flip($keys));
            }
        };
    }

}