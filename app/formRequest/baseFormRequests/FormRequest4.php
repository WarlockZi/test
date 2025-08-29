<?php

namespace app\formRequest\baseFormRequests;


use Illuminate\Validation\ValidationException;

abstract class FormRequest4
{
    protected $validator;
    protected array $allowedFields;

    abstract public function rules();

    public function authorize(): bool
    {
        return false; // Override in child classes if needed
    }

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }

    public function validate()
    {
        if (!$this->authorize()) {
            throw new \Exception('Unauthorized');
        }

        $validator = $this->getValidator();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->validated();
    }

    protected function getValidator()
    {
        $validator = APP->get('validator');

        return $validator->make(
            $this->all(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );
    }

    public function validated()
    {
        return $this->getValidator()->validated();
    }

    public function all($keys=null): array
    {
        $json = json_decode(file_get_contents('php://input'), true);
        $data = array_merge($_GET, $_POST, $json) ?? [];

        if (!empty($this->allowedFields)) {
            $data =  collect($data)
                ->only($this->allowedFields)
                ->toArray();
        }
        return $data;
    }


    public function errors()
    {
        return $this->getValidator()->errors();
    }
}