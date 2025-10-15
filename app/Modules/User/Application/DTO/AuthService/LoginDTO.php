<?php

namespace App\Modules\User\Application\DTO\AuthService;

final readonly class LoginDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
