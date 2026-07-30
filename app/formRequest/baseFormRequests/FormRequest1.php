<?php

namespace app\formRequest\baseFormRequests;

use Illuminate\Http\Request;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

abstract class FormRequest1 extends Request
{
    protected Validator $validator;

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

    protected function getValidator()
    {
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

    public function validate(): void
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
        $this->authorize();
        $this->prepareForValidation();
        $validator = $this->getValidator();

        if (isset($this->input['phpSession'])) {
            unset($this->input['phpSession']);
        }

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
//            response()->json(['popup' => $errors]);
            response()->json(['popup' => $this->errorsToString($errors)]);
        }

        return $validator->validated();
    }

    private function errorsToString(array $errors):string
    {
        return implode(',', $errors);
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

    public function authorize(): bool
    {
        return true;
    }

    abstract public function rules();

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }

    protected function prepareForValidation()
    {
    }

    protected function passedValidation()
    {
    }


}