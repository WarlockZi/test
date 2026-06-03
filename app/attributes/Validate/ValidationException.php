<?php
declare(strict_types=1);

namespace app\attributes\Validate;

use InvalidArgumentException;
use Throwable;

class ValidationException extends InvalidArgumentException
{
    /**
     * @var array<string, array<string>> Ассоциативный массив ошибок: ['field' => ['error1', 'error2']]
     */
    private readonly array $errors;

    /**
     * @param array<string, array<string>|string> $errors Ошибки валидации
     * @param string $message Сообщение исключения
     * @param int $code Код ошибки
     * @param Throwable|null $previous Предыдущее исключение
     */
    public function __construct(
        array      $errors,
        string     $message = 'The given data was invalid.',
        int        $code = 422,
        ?Throwable $previous = null
    )
    {
        // Нормализуем ошибки: приводим все значения к array<string>
        $this->errors = $this->normalizeErrors($errors);

        parent::__construct($message, $code, $previous);
    }

    /**
     * Получить все ошибки в виде массива
     *
     * @return array<string, array<string>>
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Получить первую ошибку для конкретного поля
     *
     * @param string $attribute Имя поля
     * @return string|null Первая ошибка или null, если ошибок нет
     */
    public function firstError(string $attribute): ?string
    {
        return $this->errors[$attribute][0] ?? null;
    }

    /**
     * Получить все ошибки для конкретного поля
     *
     * @param string $attribute Имя поля
     * @return array<string> Массив ошибок
     */
    public function fieldErrors(string $attribute): array
    {
        return $this->errors[$attribute] ?? [];
    }

    /**
     * Проверить, есть ли ошибки для конкретного поля
     *
     * @param string $attribute Имя поля
     * @return bool
     */
    public function hasError(string $attribute): bool
    {
        return !empty($this->errors[$attribute]);
    }

    /**
     * Получить список всех полей с ошибками
     *
     * @return array<string>
     */
    public function failedFields(): array
    {
        return array_keys($this->errors);
    }

    /**
     * Преобразовать исключение в массив (для API ответов)
     *
     * @return array{message: string, errors: array<string, array<string>>}
     */
    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'errors' => $this->errors,
        ];
    }

    /**
     * Нормализация формата ошибок
     * Приводит ['field' => 'error'] к ['field' => ['error']]
     *
     * @param array<string, array<string>|string> $errors
     * @return array<string, array<string>>
     */
    private function normalizeErrors(array $errors): array
    {
        $normalized = [];

        foreach ($errors as $field => $messages) {
            if (is_string($messages)) {
                $normalized[$field] = [$messages];
            } elseif (is_array($messages)) {
                // Фильтруем пустые значения и приводим к строкам
                $normalized[$field] = array_values(array_filter(
                    array_map('strval', $messages)
                ));
            }
        }

        return $normalized;
    }
}