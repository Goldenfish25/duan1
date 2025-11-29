<?php

namespace App\Services;

use App\Models\CartItem;
use App\Repositories\OrderRepository;

class OrderService
{
    private OrderRepository $orders;
    private CartService $cart;

    public function __construct()
    {
        $this->orders = new OrderRepository();
        $this->cart = new CartService();
    }

    public function checkout(int $userId, array $payload): array
    {
        $items = $this->cart->items();
        if (empty($items)) {
            throw new \RuntimeException('Giỏ hàng trống');
        }

        $orderItems = array_map(fn (CartItem $item) => [
            'food_id' => $item->food_id,
            'quantity' => $item->quantity,
            'price' => $item->price,
        ], $items);

        $order = $this->orders->create([
            'user_id' => $userId,
            'total' => $this->cart->total(),
            'status' => 'pending',
            'delivery_address' => $payload['delivery_address'],
            'payment_method' => $payload['payment_method'],
            'notes' => $payload['notes'] ?? null,
        ], $orderItems);

        $this->cart->clear();

        return ['order' => $order, 'items' => $orderItems];
    }
}

