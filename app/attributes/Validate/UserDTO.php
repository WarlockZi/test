<?php

namespace app\attributes\Validate;

class UserDTO
{
    public function __construct(
        #[Validate(['required', 'integer', 'min:0'])]
        public int $id,
        #[Validate(['required', 'email'])]
        public string $email,
        #[Validate(['required', 'string', 'min:3'])]
        public string $name,
        #[Validate(['required', 'string', 'min:3'])]
        public string $surName,
        #[Validate(['required', 'string', 'min:3'])]
        public string $middleName,
        #[Validate(['required', 'string', 'min:3'])]
        public string $phone,
        #[Validate(['required', 'string', 'min:3'])]
        public string $birthDate,
        #[Validate(['required', 'string', 'min:1'])]
        public string $sex,

    ) {}

    public static function fromArray(array $data): self
    {
        $dto = new self(
            id: $data['id'] ?? 0,
            email: $data['email'] ?? '',
            name: $data['name'] ?? '',
            surName: $data['surName'] ?? '',
            middleName: $data['middleName'] ?? '',
            phone: $data['phone'] ?? '',
            birthDate: $data['birthDate'] ?? '',
            sex: $data['sex'] ?? '',
        );

        // Валидация через отдельный класс
        $validator = new DtoValidator();
        $validator->validate($dto);

        return $dto;
    }
}