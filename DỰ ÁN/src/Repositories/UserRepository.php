<?php

namespace App\Repositories;

use App\Database\Connection;
use App\Models\User;
use PDO;

class UserRepository
{
    public function findByEmail(string $email): ?User
    {
        $stmt = Connection::get()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $data = $stmt->fetch();
        return $data ? $this->map($data) : null;
    }

    public function find(int $id): ?User
    {
        $stmt = Connection::get()->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ? $this->map($data) : null;
    }

    public function create(array $payload): User
    {
        $stmt = Connection::get()->prepare('
            INSERT INTO users (name, email, password, role, phone, address)
            VALUES (:name, :email, :password, :role, :phone, :address)
        ');
        $stmt->execute([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => password_hash($payload['password'], PASSWORD_BCRYPT),
            'role' => $payload['role'] ?? 'user',
            'phone' => $payload['phone'] ?? null,
            'address' => $payload['address'] ?? null,
        ]);

        return $this->find((int) Connection::get()->lastInsertId());
    }

    public function allUsers(): array
    {
        $stmt = Connection::get()->query('SELECT * FROM users ORDER BY created_at DESC');
        return array_map(fn ($row) => $this->map($row), $stmt->fetchAll());
    }

    private function map(array $row): User
    {
        return new User(
            id: (int) $row['id'],
            name: $row['name'],
            email: $row['email'],
            password: $row['password'],
            role: $row['role'],
            phone: $row['phone'],
            address: $row['address'],
            created_at: $row['created_at']
        );
    }
}

