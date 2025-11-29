<?php

namespace App\Models;

class User
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public string $password,
        public string $role = 'user',
        public ?string $phone = null,
        public ?string $address = null,
        public ?string $created_at = null
    ) {
    }
}

