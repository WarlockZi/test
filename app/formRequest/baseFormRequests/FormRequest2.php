<?php

namespace app\formRequest\baseFormRequests;


use app\service\Router\IRequest;
use app\service\Validator\Validator;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;

abstract class FormRequest2 extends Request implements IRequest
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

    protected function getInputFromGlobal(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $rawInput    = file_get_contents('php://input');

        if (str_contains($contentType, 'application/json')) {
            return json_decode($rawInput, true) ?? [];
        } elseif (str_contains($contentType, 'application/x-www-form-urlencoded')) {
            parse_str($rawInput, $input);
            return $input;
        } elseif (str_contains($contentType, 'multipart/form-data')) {
            return $_POST + $_GET + $_FILES;
        }
        return $_POST + $_GET;
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
        $this->errors = $validator->validate();

        return empty($this->errors);
    }

    protected function getValidator(): Validator
    {
        return new Validator(
            $this->all(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );
    }

    public function validated(): array
    {
        if (!$this->validate()) {
            $errors = $this->errors['file'] ?? $this->errors;
            response()->json(['popup' => $errors[0]]);
//            throw new RuntimeException('Validation failed.');
        }

        return array_intersect_key(
            $this->all(),
            array_flip(array_keys($this->rules()))
        );
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
            json_decode($this->getContent(), true)??[]
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