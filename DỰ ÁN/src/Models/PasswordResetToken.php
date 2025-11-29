<?php

namespace App\Models;

class PasswordResetToken
{
    public function __construct(
        public string $token,
        public string $email,
        public string $expires_at,
        public ?string $created_at = null
    ) {
    }
}

