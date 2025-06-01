<?php

namespace app\service\FormRequest;


use app\service\Validator\Validator;
use Exception;
use RuntimeException;

abstract class FormRequest
{
    /**
     * Входные данные запроса
     * @var array
     */
    protected $input = [];

    /**
     * Ошибки валидации
     * @var array
     */
    protected $errors = [];

    /**
     * Правила валидации
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Сообщения об ошибках
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Пользовательские имена атрибутов
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * FormRequest constructor.
     * @param array $input
     */
    public function __construct(array $input = [])
    {
        $this->input = $input ?: $this->getInputFromGlobal();
    }

    /**
     * Получает входные данные из глобальных переменных
     * @return array
     */
    protected function getInputFromGlobal(): array
    {
        return $_POST + $_GET;
    }

    /**
     * Проверяет авторизацию пользователя
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Запускает валидацию
     * @return bool
     * @throws Exception
     */
    public function validate(): bool
    {
        if (!$this->authorize()) {
            throw new RuntimeException('Unauthorized action.');
        }

        $validator = $this->getValidator();
        $this->errors = $validator->validate();

        return empty($this->errors);
    }

    /**
     * Создает экземпляр валидатора
     * @return Validator
     */
    protected function getValidator(): Validator
    {
        return new Validator(
            $this->input,
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );
    }

    /**
     * Получает валидированные данные
     * @return array
     * @throws Exception
     */
    public function validated(): array
    {
        if (!$this->validate()) {
            throw new RuntimeException('Validation failed.');
        }

        return array_intersect_key(
            $this->input,
            array_flip(array_keys($this->rules()))
        );
    }

    /**
     * Получает все ошибки валидации
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Получает значение из входных данных
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function input(string $key, $default = null)
    {
        return $this->input[$key] ?? $default;
    }

    /**
     * Получает все входные данные
     * @return array
     */
    public function all(): array
    {
        return $this->input;
    }
}