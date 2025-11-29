<?php

namespace App\Repositories;

use App\Database\Connection;
use App\Models\Order;
use App\Models\OrderItem;
use PDO;

class OrderRepository
{
    public function create(array $payload, array $items): Order
    {
        $pdo = Connection::get();
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('
                INSERT INTO orders (user_id, total, status, delivery_address, payment_method, notes)
                VALUES (:user_id, :total, :status, :delivery_address, :payment_method, :notes)
            ');
            $stmt->execute([
                'user_id' => $payload['user_id'],
                'total' => $payload['total'],
                'status' => $payload['status'] ?? 'pending',
                'delivery_address' => $payload['delivery_address'],
                'payment_method' => $payload['payment_method'],
                'notes' => $payload['notes'] ?? null,
            ]);

            $orderId = (int) $pdo->lastInsertId();

            $itemStmt = $pdo->prepare('
                INSERT INTO order_items (order_id, food_id, quantity, price)
                VALUES (:order_id, :food_id, :quantity, :price)
            ');

            foreach ($items as $item) {
                $itemStmt->execute([
                    'order_id' => $orderId,
                    'food_id' => $item['food_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            $pdo->commit();
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }

        return $this->find($orderId);
    }

    public function find(int $id): ?Order
    {
        $stmt = Connection::get()->prepare('SELECT * FROM orders WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $this->mapOrder($row) : null;
    }

    public function findWithItems(int $id): ?array
    {
        $order = $this->find($id);
        if (!$order) {
            return null;
        }

        $stmt = Connection::get()->prepare('SELECT * FROM order_items WHERE order_id = ?');
        $stmt->execute([$id]);
        $items = array_map(fn ($row) => $this->mapItem($row), $stmt->fetchAll());

        return ['order' => $order, 'items' => $items];
    }

    public function ordersForUser(int $userId): array
    {
        $stmt = Connection::get()->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return array_map(fn ($row) => $this->mapOrder($row), $stmt->fetchAll());
    }

    public function all(): array
    {
        $stmt = Connection::get()->query('SELECT * FROM orders ORDER BY created_at DESC');
        return array_map(fn ($row) => $this->mapOrder($row), $stmt->fetchAll());
    }

    public function updateStatus(int $orderId, string $status): void
    {
        $stmt = Connection::get()->prepare('UPDATE orders SET status = ? WHERE id = ?');
        $stmt->execute([$status, $orderId]);
    }

    private function mapOrder(array $row): Order
    {
        return new Order(
            id: (int) $row['id'],
            user_id: (int) $row['user_id'],
            total: (float) $row['total'],
            status: $row['status'],
            delivery_address: $row['delivery_address'],
            payment_method: $row['payment_method'],
            notes: $row['notes'],
            created_at: $row['created_at']
        );
    }

    private function mapItem(array $row): OrderItem
    {
        return new OrderItem(
            id: (int) $row['id'],
            order_id: (int) $row['order_id'],
            food_id: (int) $row['food_id'],
            quantity: (int) $row['quantity'],
            price: (float) $row['price']
        );
    }
}

