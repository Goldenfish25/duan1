<?php

namespace App\Services;

use App\Core\Session;
use App\Models\CartItem;
use App\Repositories\FoodRepository;

class CartService
{
    private const SESSION_KEY = 'cart_items';
    private FoodRepository $foods;

    public function __construct()
    {
        $this->foods = new FoodRepository();
    }

    /**
     * @return CartItem[]
     */
    public function items(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function add(int $foodId, int $quantity = 1): void
    {
        $food = $this->foods->find($foodId);
        if (!$food) {
            throw new \RuntimeException('Món ăn không tồn tại');
        }

        $cart = $this->items();
        if (isset($cart[$foodId])) {
            $cart[$foodId]->quantity += $quantity;
        } else {
            $cart[$foodId] = new CartItem($foodId, $food->name, $food->price, $food->thumbnail, $quantity);
        }

        Session::put(self::SESSION_KEY, $cart);
    }

    public function update(int $foodId, int $quantity): void
    {
        $cart = $this->items();
        if ($quantity <= 0) {
            unset($cart[$foodId]);
        } elseif (isset($cart[$foodId])) {
            $cart[$foodId]->quantity = $quantity;
        }
        Session::put(self::SESSION_KEY, $cart);
    }

    public function remove(int $foodId): void
    {
        $cart = $this->items();
        unset($cart[$foodId]);
        Session::put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function total(): float
    {
        return array_reduce($this->items(), fn ($carry, CartItem $item) => $carry + $item->subtotal(), 0.0);
    }
}

