<?php

namespace App\Models;

class Category
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $slug,
        public ?string $created_at = null
    ) {
    }
}

