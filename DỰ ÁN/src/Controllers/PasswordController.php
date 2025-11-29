<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Services\PasswordResetService;

class PasswordController extends Controller
{
    public function __construct(private PasswordResetService $resets = new PasswordResetService())
    {
        parent::__construct();
    }

    public function showForgot(): void
    {
        $this->view('auth/forgot-password');
    }

    public function sendLink(Request $request): void
    {
        try {
            $token = $this->resets->createToken($request->input('email'));
            Session::flash('success', 'Đã gửi liên kết đặt lại mật khẩu (xem file reset-links.log)');
        } catch (\Throwable $e) {
            Session::flash('error', $e->getMessage());
        }

        $this->back();
    }

    public function showReset(Request $request): void
    {
        $this->view('auth/reset-password', [
            'token' => $request->input('token'),
        ]);
    }

    public function reset(Request $request): void
    {
        $token = $request->input('token');
        $password = $request->input('password');
        $passwordConfirm = $request->input('password_confirmation');

        if ($password !== $passwordConfirm) {
            Session::flash('error', 'Mật khẩu xác nhận không khớp');
            $this->back();
            return;
        }

        try {
            $this->resets->resetPassword($token, $password);
            Session::flash('success', 'Đặt lại mật khẩu thành công');
            $this->redirect('/login');
        } catch (\Throwable $e) {
            Session::flash('error', $e->getMessage());
            $this->back();
        }
    }
}

