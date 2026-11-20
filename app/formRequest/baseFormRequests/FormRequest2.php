<?php

namespace app\formRequest\baseFormRequests;


//use app\service\Validator\Validator;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;

abstract class FormRequest2 extends Request
{
    protected $input = [];
    protected $errors = [];

    public function __construct()
    {
        $request = Request::createFromGlobals();

        parent::__construct(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $request->getContent());
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
        return true;
    }

    public function validate(): bool
    {
        if (!$this->authorize()) {
            throw new RuntimeException('Unauthorized action.');
        }

        $validator    = $this->getValidator();
        if ($validator->fails()) {
            $this->errors = $validator->errors()->all();
            return false;
        }

        return empty($this->errors);
    }

    protected function getValidator()
    {
        $factory = app('validator');
        $validator = $factory->make(
            $this->all(),
            $this->rules(),
            $this->messages(),
            $this->attributes());

        return $validator;
//        $validator =  Validator::make(
//            $this->all(),
//            $this->rules(),
//            $this->messages(),
//            $this->attributes()
//        );
//        return $validator;
    }

    public function validated(): array
    {
        if (!$this->validate()) {
            $errors       = $this->errors['file'] ?? $this->errors;
            $errorsString = json_encode($errors);

            response()->json(['popup' => $errorsString]);
        }

        return array_intersect_key(
            $this->all(),
            array_flip(array_keys($this->rules()))
        );
    }

    protected function errorsToString(array $errors): string
    {
        $errorsString = '';
        foreach ($errors as $name=>$error) {
            $errorsString .= $error;
        }
        return $errorsString;
    }


    public function errors(): array
    {
        return $this->errors;
    }

    public function input(string $key, $default = null)
    {
        return $this->input[$key] ?? $default;
    }

    public function all($keys = []): array
    {
        return array_merge(
            $this->query->all(),
            $this->request->all(),
            $this->files->all(),
            json_decode($this->getContent(), true) ?? []
        );
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
}