<?php

namespace App\Models;

class Food
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $slug,
        public string $description,
        public float $price,
        public string $thumbnail,
        public int $category_id,
        public bool $is_active = true,
        public ?string $created_at = null
    ) {
    }
}

