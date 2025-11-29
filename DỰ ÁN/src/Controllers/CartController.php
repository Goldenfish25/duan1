<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(private CartService $cart = new CartService())
    {
        parent::__construct();
    }

    public function index(): void
    {
        $this->view('cart/index', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function add(Request $request): void
    {
        try {
            $this->cart->add((int) $request->input('food_id'), (int) $request->input('quantity', 1));
            Session::flash('success', 'Đã thêm món vào giỏ');
        } catch (\Throwable $e) {
            Session::flash('error', $e->getMessage());
        }

        $this->back();
    }

    public function update(Request $request): void
    {
        $this->cart->update((int) $request->input('food_id'), (int) $request->input('quantity'));
        $this->back();
    }

    public function remove(Request $request): void
    {
        $this->cart->remove((int) $request->input('food_id'));
        $this->back();
    }
}

