<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\CategoryRepository;
use App\Repositories\FoodRepository;
use App\Repositories\OrderRepository;

class AdminController extends Controller
{
    public function __construct(
        private FoodRepository $foods = new FoodRepository(),
        private CategoryRepository $categories = new CategoryRepository(),
        private OrderRepository $orders = new OrderRepository()
    ) {
        parent::__construct();
        if (!$this->auth->isAdmin()) {
            Session::flash('error', 'Bạn không có quyền truy cập');
            $this->redirect('/');
        }
    }

    public function dashboard(): void
    {
        $this->view('admin/dashboard', [
            'orders' => $this->orders->all(),
            'foods' => $this->foods->paginate(5),
        ]);
    }

    public function foods(): void
    {
        $this->view('admin/foods/index', [
            'foods' => $this->foods->paginate(50),
        ]);
    }

    public function createFood(): void
    {
        $this->view('admin/foods/form', [
            'categories' => $this->categories->all(),
        ]);
    }

    public function storeFood(Request $request): void
    {
        $data = $request->only(['name', 'slug', 'description', 'price', 'thumbnail', 'category_id']);
        $this->foods->create($data);
        Session::flash('success', 'Đã thêm món ăn');
        $this->redirect('/admin/foods');
    }

    public function editFood(Request $request): void
    {
        $food = $this->foods->find((int) $request->routeParam(0));
        $this->view('admin/foods/form', [
            'food' => $food,
            'categories' => $this->categories->all(),
        ]);
    }

    public function updateFood(Request $request): void
    {
        $id = (int) $request->routeParam(0);
        $data = $request->only(['name', 'slug', 'description', 'price', 'thumbnail', 'category_id', 'is_active']);
        $data['is_active'] = $data['is_active'] ?? 0;
        $this->foods->update($id, $data);
        Session::flash('success', 'Đã cập nhật món ăn');
        $this->redirect('/admin/foods');
    }

    public function deleteFood(Request $request): void
    {
        $this->foods->delete((int) $request->routeParam(0));
        Session::flash('success', 'Đã xóa món ăn');
        $this->redirect('/admin/foods');
    }

    public function orders(): void
    {
        $this->view('admin/orders/index', [
            'orders' => $this->orders->all(),
        ]);
    }

    public function updateOrderStatus(Request $request): void
    {
        $this->orders->updateStatus((int) $request->routeParam(0), $request->input('status'));
        $this->back();
    }
}

