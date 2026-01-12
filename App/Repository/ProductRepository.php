<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

final class ProductRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT p.id, p.name, p.brand, p.reference, p.quantity, p.price, p.availability,
                   p.category_id, c.name AS category_name, p.users_id
            FROM products p
            JOIN category c ON c.id = p.category_id
            ORDER BY p.id ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.name AS category_name
            FROM products p
            JOIN category c ON c.id = p.category_id
            WHERE p.id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByCategory(int $categoryId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT p.id, p.name, p.brand, p.reference, p.quantity, p.price, p.availability,
                   p.category_id, c.name AS category_name, p.users_id
            FROM products p
            JOIN category c ON c.id = p.category_id
            WHERE p.category_id = :category_id
            ORDER BY p.id DESC
        ");
        $stmt->execute([':category_id' => $categoryId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO products (name, brand, reference, quantity, price, availability, category_id, users_id)
            VALUES (:name, :brand, :reference, :quantity, :price, :availability, :category_id, :users_id)
        ");

        $stmt->execute([
            ':name'         => $data['name'],
            ':brand'        => $data['brand'] ?? null,
            ':reference'    => $data['reference'] ?? null,
            ':quantity'     => $data['quantity'] ?? 0,
            ':price'        => $data['price'] ?? 0.0,
            ':availability' => $data['availability'] ?? 0,
            ':category_id'  => $data['category_id'],
            ':users_id'     => $data['users_id'],
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE products
            SET name = :name,
                brand = :brand,
                reference = :reference,
                quantity = :quantity,
                price = :price,
                availability = :availability,
                category_id = :category_id
            WHERE id = :id
        ");

        $stmt->execute([
            ':id'           => $id,
            ':name'         => $data['name'],
            ':brand'        => $data['brand'] ?? null,
            ':reference'    => $data['reference'] ?? null,
            ':quantity'     => $data['quantity'] ?? 0,
            ':price'        => $data['price'] ?? 0.0,
            ':availability' => $data['availability'] ?? 0,
            ':category_id'  => $data['category_id'],
        ]);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
