<?php

namespace App\Services;

use App\Repositories\PasswordResetRepository;
use DateInterval;
use DateTimeImmutable;

class PasswordResetService
{
    private PasswordResetRepository $tokens;
    private UserService $users;

    public function __construct()
    {
        $this->tokens = new PasswordResetRepository();
        $this->users = new UserService();
    }

    public function createToken(string $email): string
    {
        $user = $this->users->findByEmail($email);
        if (!$user) {
            throw new \RuntimeException('Email không tồn tại');
        }

        $token = bin2hex(random_bytes(32));
        $expires = (new DateTimeImmutable())->add(new DateInterval('PT' . ($_ENV['RESET_TOKEN_EXPIRY_MINUTES'] ?? 30) . 'M'));

        $this->tokens->create($email, $token, $expires);

        file_put_contents(
            __DIR__ . '/../../storage/logs/reset-links.log',
            sprintf("[%s] %s -> %s\n", date('c'), $email, $this->resetUrl($token)),
            FILE_APPEND
        );

        return $token;
    }

    public function resetPassword(string $token, string $password): void
    {
        $record = $this->tokens->find($token);
        if (!$record) {
            throw new \RuntimeException('Token không hợp lệ');
        }

        if (new DateTimeImmutable($record->expires_at) < new DateTimeImmutable()) {
            throw new \RuntimeException('Token đã hết hạn');
        }

        $this->users->updatePassword($record->email, $password);
        $this->tokens->delete($token);
    }

    private function resetUrl(string $token): string
    {
        $base = $_ENV['APP_URL'] ?? 'http://localhost';
        return rtrim($base, '/') . '/reset-password?token=' . $token;
    }
}

