<?php

namespace app\attributes\Validate;

use ReflectionClass;

class DTOValidator
{
    public function validate(object $dto): void
    {
        $reflection = new ReflectionClass($dto);
        $errors = [];

        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(Validate::class);

            if (empty($attributes)) {
                continue;
            }

            $validateAttribute = $attributes[0]->newInstance();
            $value = $property->getValue($dto);

            // Здесь можно использовать любую библиотеку валидации
            // Например, Symfony Validator или кастомную логику
            $propertyErrors = $this->validateProperty(
                $property->getName(),
                $value,
                $validateAttribute->rules
            );

            if (!empty($propertyErrors)) {
                $errors[$property->getName()] = $propertyErrors;
            }
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }
    private function validateProperty(string $name, mixed $value, array $rules): array
    {
        $errors = [];

        foreach ($rules as $rule) {
            switch ($rule) {
                case 'required':
                    if ($value === null || $value === '') {
                        $errors[] = "$name is required";
                    }
                    break;

                case 'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "$name must be a valid email";
                    }
                    break;

                case 'string':
                    if (!is_string($value)) {
                        $errors[] = "$name must be a string";
                    }
                    break;

                case 'integer':
                    if (!is_int($value)) {
                        $errors[] = "$name must be an integer";
                    }
                    break;

                // Добавьте другие правила по необходимости
            }
        }

        return $errors;
    }
}