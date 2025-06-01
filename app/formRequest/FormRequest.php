<?php

namespace app\formRequest;

use app\service\Validator\Validator;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

abstract class FormRequest
{
    public function authorize()
    {
        return true;
    }

    abstract public function rules();

    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }


    public function validate()
    {
        if (!$this->authorize()) {
            throw new \Exception('Unauthorized', 403);
        }

        $validator = $this->createValidator();

        if ($validator->fails()) {
            $this->throwValidationException($validator);
        }
    }

    protected function createValidator(): \Illuminate\Validation\Validator
    {

        $factory = new Factory(
            new Translator(
                new ArrayLoader(), 'ru'
            )
        );

        return $factory->make(
            $this->all(),
//            $this->getInputData(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );
    }
    public function validated(): array
    {
        return $this->createValidator()->validated();
    }
    protected function throwValidationException($validator)
    {
        throw new ValidationException($validator);
    }

    public function all():array
    {
        // You'll need to implement this based on your request handling
        // For example, if using $_POST:
        return ['post'=>$_POST, 'files'=>$_FILES];
    }

}

class ValidationException extends \Exception
{
    protected $validator;

    public function __construct($validator)
    {
        $this->validator = $validator;
        parent::__construct('The given data was invalid.');
    }

    public function errors()
    {
        return $this->validator->errors();
    }
}