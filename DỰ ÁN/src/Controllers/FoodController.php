<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\FoodRepository;

class FoodController extends Controller
{
    public function __construct(private FoodRepository $foods = new FoodRepository())
    {
        parent::__construct();
    }

    public function index(): void
    {
        $this->view('menu', [
            'foods' => $this->foods->allActive(),
            'user' => $this->auth->user(),
        ]);
    }

    public function show(Request $request): void
    {
        $food = $this->foods->find((int) $request->routeParam(0));
        if (!$food) {
            $this->redirect('/menu');
        }

        $this->view('food-detail', [
            'food' => $food,
            'user' => $this->auth->user(),
        ]);
    }
}

