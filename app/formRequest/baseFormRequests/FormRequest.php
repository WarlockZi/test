<?php

namespace app\formRequest\j;

use Illuminate\Http\Request;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

abstract class FormRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
    }

    public function attributes(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        return true;
    }

    abstract public function rules();

    public function messages(): array
    {
        return [];
    }

    public function validate(): void
    {
        if (!$this->authorize()) {
            throw new \Exception('Unauthorized', 403);
        }

        $validator = $this->createValidator();

        if ($validator->fails()) {
            $this->throwValidationException($validator);
        }
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

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validated(): array
    {
        return $this->createValidator()->validated();
    }

    /**
     * @throws ValidationException
     */
    protected function throwValidationException($validator)
    {
        throw new ValidationException($validator);
    }

    public function all($keys=null): array
    {
        // You'll need to implement this based on your request handling
        // For example, if using $_POST:
//        return [];
        return ['post' => $_POST, 'files' => $_FILES];
    }

}

