<?php

namespace App\Repositories;

use App\Database\Connection;
use App\Models\Food;

class FoodRepository
{
    public function allActive(): array
    {
        $stmt = Connection::get()->query('SELECT * FROM foods WHERE is_active = 1 ORDER BY created_at DESC');
        return array_map(fn ($row) => $this->map($row), $stmt->fetchAll());
    }

    public function paginate(int $limit = 12): array
    {
        $stmt = Connection::get()->prepare('SELECT * FROM foods ORDER BY created_at DESC LIMIT ?');
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return array_map(fn ($row) => $this->map($row), $stmt->fetchAll());
    }

    public function find(int $id): ?Food
    {
        $stmt = Connection::get()->prepare('SELECT * FROM foods WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $this->map($row) : null;
    }

    public function create(array $payload): Food
    {
        $stmt = Connection::get()->prepare('
            INSERT INTO foods (name, slug, description, price, thumbnail, category_id, is_active)
            VALUES (:name, :slug, :description, :price, :thumbnail, :category_id, :is_active)
        ');
        $stmt->execute([
            'name' => $payload['name'],
            'slug' => $payload['slug'],
            'description' => $payload['description'],
            'price' => $payload['price'],
            'thumbnail' => $payload['thumbnail'] ?? '/images/placeholder.jpg',
            'category_id' => $payload['category_id'],
            'is_active' => $payload['is_active'] ?? 1,
        ]);

        return $this->find((int) Connection::get()->lastInsertId());
    }

    public function update(int $id, array $payload): void
    {
        $stmt = Connection::get()->prepare('
            UPDATE foods 
            SET name=:name, slug=:slug, description=:description, price=:price, thumbnail=:thumbnail,
                category_id=:category_id, is_active=:is_active
            WHERE id=:id
        ');
        $payload['id'] = $id;
        $stmt->execute($payload);
    }

    public function delete(int $id): void
    {
        $stmt = Connection::get()->prepare('DELETE FROM foods WHERE id = ?');
        $stmt->execute([$id]);
    }

    private function map(array $row): Food
    {
        return new Food(
            id: (int) $row['id'],
            name: $row['name'],
            slug: $row['slug'],
            description: $row['description'],
            price: (float) $row['price'],
            thumbnail: $row['thumbnail'],
            category_id: (int) $row['category_id'],
            is_active: (bool) $row['is_active'],
            created_at: $row['created_at']
        );
    }
}

