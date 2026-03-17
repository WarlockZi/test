<?php

namespace app\service\Validator;


class Validator
{
    protected array $mimes = [
        "image/jpg" => "jpg",
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp",
    ];
    protected array $data;
    protected array $rules;
    protected array $messages;
    protected array $attributes;
    protected array $errors = [];

    public function __construct(array $data, array $rules, array $messages = [], array $attributes = [])
    {
        $this->data       = $data;
        $this->rules      = $rules;
        $this->messages   = $messages;
        $this->attributes = $attributes;
    }

    public function validate(): array
    {
        foreach ($this->rules as $field => $rules) {
            $rules = is_array($rules) ? $rules : explode('|', $rules);
//            $field = $this->getFieldName($field);
            $value = $this->data[$field] ?? null;

            foreach ($rules as $rule) {
                $this->validateRule($field, $value, $rule);
            }
        }

        return $this->errors;
    }

    protected function validateRule(string $field, $value, string $rule): void
    {
        $params = [];

        if (str_contains($rule, ':')) {
            [$rule, $params] = explode(':', $rule, 2);
            $params = explode(',', $params);
        }

        $method = 'validate' . ucfirst($rule);

        if (method_exists($this, $method)) {
            $this->$method($field, $value, $params, $rule);
        }
    }
    protected function validateArray(string $field, $value, array $params, string $rule): void
    {
        if (!is_array($value)) {
            $this->addError($field, "{$field}{$rule}");
        }
    }
    protected function validateImage(string $field, $value, array $params): void
    {
        if (!str_contains($value->getMimeType(), 'image') ) {
            $this->addError($field, 'file.image');
        }
    }

    protected function validateMimes(string $field, $value, array $params): void
    {
        $found = false;
        foreach ($params as $param) {
            if (str_contains($value->getMimeType(), $param,)) {
                $found = true;
            }
        }
        if (!$found) {
            $this->addError($field, 'file.mimes');
        }
    }

    protected function validateRequired(string $field, $value, array $params): void
    {
        if (is_null($value) || $value === '' || (is_array($value) && empty($value))) {
            $this->addError($field, 'required');
        }
    }

    protected function validateEmail(string $field, $value, array $params): void
    {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'email');
        }
    }

    protected function validateMin(string $field, $value, array $params): void
    {
        if (!empty($value) && strlen($value) < $params[0]) {
            $this->addError($field, 'min', $params);
        }
    }

    protected function validateMax(string $field, $value, array $params): void
    {
        if (is_string($value)) {
            if (!empty($value) && strlen($value) > $params[0]) {
                $this->addError($field, 'max', $params);
            }
        } elseif (is_numeric($value)) {
            if (!empty($value) && $value > $params[0]) {
                $this->addError($field, 'max', $params);
            }
        } else {
            if ($value->getSize() > $params[0]) {
                $this->addError($field, 'max', $params);
            }
        }
    }

    protected function addError(string $field, string $rule, array $params = []): void
    {
        $message                = $this->messages["$rule"] ?? $this->getDefaultMessage($field, $rule, $params);
        $this->errors[$field][] = $message;
    }

    protected function getDefaultMessage(string $field, string $rule, array $params): string
    {
        $attribute = $this->attributes[$field] ?? $field;

        switch ($rule) {
            case 'required':
                return "Поле {$attribute} обязательно для заполнения.";
            case 'email':
                return "Поле {$attribute} должно быть валидным email адресом.";
            case 'min':
                return "Поле {$attribute} должно быть не менее {$params[0]} символов.";
            case 'max':
                return "Поле {$attribute} должно быть не более {$params[0]} символов.";
            default:
                return "Поле {$attribute} не прошло валидацию.";
        }
    }
}