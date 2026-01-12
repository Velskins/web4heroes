<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

final class CategoryRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT c.id, c.name, c.description
            FROM category c
            ORDER BY c.name ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT c.id, c.name, c.description
            FROM category c
            WHERE c.id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO category (name, description)
            VALUES (:name, :description)
        ");

        $stmt->execute([
            ':name'        => $data['name'],
            ':description' => $data['description'] ?? null,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE category
            SET name = :name,
                description = :description
            WHERE id = :id
        ");

        $stmt->execute([
            ':id'          => $id,
            ':name'        => $data['name'],
            ':description' => $data['description'] ?? null,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $check = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM products
            WHERE category_id = :id
        ");
        $check->execute([':id' => $id]);

        if ((int) $check->fetchColumn() > 0) {
            return false;
        }

        $stmt = $this->pdo->prepare("
            DELETE FROM category
            WHERE id = :id
        ");
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
