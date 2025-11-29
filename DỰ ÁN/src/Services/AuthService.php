<?php

namespace App\Services;

use App\Core\Session;
use App\Models\User;
use App\Repositories\UserRepository;

class AuthService
{
    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }

    public function attempt(string $email, string $password): bool
    {
        $user = $this->users->findByEmail($email);
        if (!$user || !password_verify($password, $user->password)) {
            return false;
        }

        Session::put('user_id', $user->id);
        Session::put('user_role', $user->role);
        return true;
    }

    public function register(array $payload): User
    {
        return $this->users->create($payload);
    }

    public function user(): ?User
    {
        $id = Session::get('user_id');
        return $id ? $this->users->find((int) $id) : null;
    }

    public function check(): bool
    {
        return Session::get('user_id') !== null;
    }

    public function isAdmin(): bool
    {
        return Session::get('user_role') === 'admin';
    }

    public function logout(): void
    {
        Session::destroy();
    }
}

