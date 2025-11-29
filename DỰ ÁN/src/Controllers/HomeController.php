<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\FoodRepository;

class HomeController extends Controller
{
    public function __construct(private FoodRepository $foods = new FoodRepository(), private CategoryRepository $categories = new CategoryRepository())
    {
        parent::__construct();
    }

    public function index(): void
    {
        $this->view('home', [
            'featuredFoods' => $this->foods->paginate(6),
            'categories' => $this->categories->all(),
            'user' => $this->auth->user(),
        ]);
    }
}

