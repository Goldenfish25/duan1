<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if ($this->auth->check()) {
            $this->redirect('/');
        }

        $this->view('auth/login');
    }

    public function login(Request $request): void
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($this->auth->attempt($email, $password)) {
            $this->redirect('/');
        }

        Session::flash('error', 'Sai email hoặc mật khẩu');
        $this->back();
    }

    public function showRegister(): void
    {
        $this->view('auth/register');
    }

    public function register(Request $request): void
    {
        $data = $request->only(['name', 'email', 'password', 'confirm_password']);

        if ($data['password'] !== $data['confirm_password']) {
            Session::flash('error', 'Mật khẩu xác nhận không khớp');
            $this->back();
            return;
        }

        $this->auth->register($data);
        Session::flash('success', 'Đăng ký thành công, hãy đăng nhập');
        $this->redirect('/login');
    }

    public function logout(): void
    {
        $this->auth->logout();
        $this->redirect('/');
    }
}

