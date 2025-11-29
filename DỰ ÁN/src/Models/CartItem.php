<?php

namespace App\Models;

class CartItem
{
    public function __construct(
        public int $food_id,
        public string $name,
        public float $price,
        public string $thumbnail,
        public int $quantity = 1
    ) {
    }

    public function subtotal(): float
    {
        return $this->price * $this->quantity;
    }
}

