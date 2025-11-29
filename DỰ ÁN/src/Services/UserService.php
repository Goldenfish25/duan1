<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }

    public function findByEmail(string $email)
    {
        return $this->users->findByEmail($email);
    }

    public function updatePassword(string $email, string $password): void
    {
        $stmt = \App\Database\Connection::get()->prepare('UPDATE users SET password = ? WHERE email = ?');
        $stmt->execute([
            password_hash($password, PASSWORD_BCRYPT),
            $email,
        ]);
    }
}

