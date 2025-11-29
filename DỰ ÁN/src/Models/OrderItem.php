<?php

namespace App\Models;

class OrderItem
{
    public function __construct(
        public ?int $id,
        public int $order_id,
        public int $food_id,
        public int $quantity,
        public float $price
    ) {
    }
}

