<?php

namespace app\formRequest;


use app\service\AuthService\Auth;
use Illuminate\Http\Request;
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
        $session = $this->all('phpSession');
        !Auth::validatePphSession($session);
        return true;
    }

    public function validate(): array
    {
        if (!$this->authorize()) {
            throw new \Exception('Unauthorized', 403);
        }

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


    public function validated(): array
    {
        return $this->createValidator()->validate();
    }

//    public function all($keys = null): array
//    {
//        // Здесь должна быть реализация получения данных запроса
//        // Например, можно использовать $_POST, $_GET или php://input
//        return array_merge($_GET, $_POST, $_FILES);
//    }
}