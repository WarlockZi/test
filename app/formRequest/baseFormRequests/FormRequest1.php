<?php

namespace app\formRequest\baseFormRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

abstract class FormRequest1 extends Request
{
    protected $validator;
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $req = Request::createFromGlobals();
        parent::__construct(
            $req->query->all(),
            $req->request->all(),
            $req->attributes->all(),
            $req->cookies->all(),
            $req->files->all(),
            $req->server->all(),
            $req->getContent());
    }

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
    protected function prepareForValidation()
    {
    }

    protected function passedValidation()
    {
    }
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    protected function getValidator()
    {
        if ($this->validator) {
            return $this->validator;
        }

        $factory = new Factory(
            new Translator(
                new ArrayLoader(), 'ru'
            )
        );

        $validator = $factory->make(
            $this->all(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );

        return $this->validator = $validator;
    }

    public function validate()
    {
        $this->prepareForValidation();

        $validator = $this->getValidator();

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        $this->passedValidation();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }

    /**
     * @throws ValidationException
     */
    public function validated()
    {
        return $this->getValidator()->validated();
    }
}