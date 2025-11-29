<?php

namespace App\Repositories;

use App\Database\Connection;
use App\Models\Category;

class CategoryRepository
{
    public function all(): array
    {
        $stmt = Connection::get()->query('SELECT * FROM categories ORDER BY name');
        return array_map(fn ($row) => $this->map($row), $stmt->fetchAll());
    }

    private function map(array $row): Category
    {
        return new Category(
            id: (int) $row['id'],
            name: $row['name'],
            slug: $row['slug'],
            created_at: $row['created_at']
        );
    }
}

