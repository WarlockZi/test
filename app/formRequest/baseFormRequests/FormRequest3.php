<?php

namespace app\formRequest;


use Exception;

abstract class FormRequest3
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Validate the request.
     *
     * @throws ValidationException
     * @throws Exception
     */
    public function validate(): array
    {
        if (!$this->authorize()) {
            throw new Exception('Unauthorized', 403);
        }

        $data = $this->all();
        $rules = $this->rules();
        $messages = $this->messages();

        $validator = new Validator($data, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        return $validator->validated();
    }

    /**
     * Get all input data.
     *
     * @return array
     */
    public function all(): array
    {
        // In a non-Laravel environment, you might get this from $_POST, $_GET, or php://input
        return array_merge($_GET, $_POST, json_decode(file_get_contents('php://input'), true) ?? []);
    }
}

class Validator
{
    protected $data;
    protected $rules;
    protected $messages;
    protected $errors = [];

    public function __construct(array $data, array $rules, array $messages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
    }

    public function fails(): bool
    {
        return !$this->passes();
    }

    public function passes(): bool
    {
        $this->errors = [];

        foreach ($this->rules as $field => $rules) {
            $rules = explode('|', $rules);
            $value = $this->data[$field] ?? null;

            foreach ($rules as $rule) {
                $this->validateRule($field, $value, $rule);
            }
        }

        return empty($this->errors);
    }

    protected function validateRule($field, $value, $rule): void
    {
        $params = [];

        if (strpos($rule, ':') !== false) {
            [$rule, $params] = explode(':', $rule, 2);
            $params = explode(',', $params);
        }

        $method = 'validate' . ucfirst($rule);

        if (method_exists($this, $method)) {
            if (!$this->$method($field, $value, $params)) {
                $this->addError($field, $rule, $params);
            }
        }
    }

    protected function addError($field, $rule, $params)
    {
        $message = $this->messages["$field.$rule"] ?? "The $field field is invalid.";

        // Simple placeholder replacement
        $message = str_replace(':attribute', $field, $message);

        foreach ($params as $i => $param) {
            $message = str_replace(":{$i}", $param, $message);
        }

        $this->errors[$field][] = $message;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function validated()
    {
        if ($this->fails()) {
            throw new Exception('Data is not valid');
        }

        $validated = [];

        foreach (array_keys($this->rules) as $field) {
            $validated[$field] = $this->data[$field] ?? null;
        }

        return $validated;
    }

    // Basic validation rules
    protected function validateRequired($field, $value, $params)
    {
        return !empty($value) || $value === '0';
    }

    protected function validateEmail($field, $value, $params)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    protected function validateMin($field, $value, $params)
    {
        if (!isset($params[0])) return false;
        $min = (int)$params[0];

        if (is_numeric($value)) {
            return $value >= $min;
        }

        if (is_string($value)) {
            return strlen($value) >= $min;
        }

        if (is_array($value)) {
            return count($value) >= $min;
        }

        return false;
    }

    // Add more validation methods as needed...
}

class ValidationException extends Exception
{
    protected $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct('The given data was invalid.');
    }

    public function errors()
    {
        return $this->errors;
    }
}