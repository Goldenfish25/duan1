<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\OrderRepository;
use App\Services\CartService;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orders = new OrderService(),
        private OrderRepository $orderRepo = new OrderRepository(),
        private CartService $cart = new CartService()
    )
    {
        parent::__construct();
    }

    public function checkout(): void
    {
        if (!$this->auth->check()) {
            $this->redirect('/login');
        }

        $this->view('checkout/index', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function placeOrder(Request $request): void
    {
        if (!$this->auth->check()) {
            $this->redirect('/login');
        }

        try {
            $order = $this->orders->checkout($this->auth->user()->id, [
                'delivery_address' => $request->input('delivery_address'),
                'payment_method' => $request->input('payment_method'),
                'notes' => $request->input('notes'),
            ]);
            Session::flash('success', 'Đặt hàng thành công #' . $order['order']->id);
            $this->redirect('/orders/' . $order['order']->id);
        } catch (\Throwable $e) {
            Session::flash('error', $e->getMessage());
            $this->back();
        }
    }

    public function index(): void
    {
        if (!$this->auth->check()) {
            $this->redirect('/login');
        }

        $orders = $this->orderRepo->ordersForUser($this->auth->user()->id);
        $this->view('orders/index', ['orders' => $orders]);
    }

    public function show(Request $request): void
    {
        $order = $this->orderRepo->findWithItems((int) $request->routeParam(0));
        if (!$order) {
            $this->redirect('/orders');
        }

        if (!$this->auth->isAdmin() && $order['order']->user_id !== $this->auth->user()?->id) {
            Session::flash('error', 'Bạn không thể xem đơn hàng này');
            $this->redirect('/orders');
        }

        $this->view('orders/show', $order);
    }
}

