<?php

namespace App\Models;

class Order
{
    public function __construct(
        public ?int $id,
        public int $user_id,
        public float $total,
        public string $status,
        public string $delivery_address,
        public string $payment_method,
        public ?string $notes = null,
        public ?string $created_at = null
    ) {
    }
}

