<?php

namespace App\Repositories;

use App\Database\Connection;
use App\Models\PasswordResetToken;
use DateTimeImmutable;

class PasswordResetRepository
{
    public function create(string $email, string $token, DateTimeImmutable $expiresAt): PasswordResetToken
    {
        $stmt = Connection::get()->prepare('
            INSERT INTO password_resets (email, token, expires_at)
            VALUES (:email, :token, :expires_at)
        ');
        $stmt->execute([
            'email' => $email,
            'token' => $token,
            'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
        ]);

        return new PasswordResetToken($token, $email, $expiresAt->format('Y-m-d H:i:s'));
    }

    public function find(string $token): ?PasswordResetToken
    {
        $stmt = Connection::get()->prepare('SELECT * FROM password_resets WHERE token = ? LIMIT 1');
        $stmt->execute([$token]);
        $row = $stmt->fetch();
        return $row ? new PasswordResetToken($row['token'], $row['email'], $row['expires_at'], $row['created_at']) : null;
    }

    public function delete(string $token): void
    {
        $stmt = Connection::get()->prepare('DELETE FROM password_resets WHERE token = ?');
        $stmt->execute([$token]);
    }
}

