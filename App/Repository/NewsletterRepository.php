<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

final class NewsletterRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM newsletter_subscribers WHERE id = :id LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findOneByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM newsletter_subscribers WHERE email = :email LIMIT 1
        ");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO newsletter_subscribers (email, subscribed_at, users_id)
            VALUES (:email, :subscribed_at, :users_id)
        ");

        $stmt->execute([
            ':email' => $data['email'],
            ':subscribed_at' => $data['subscribed_at'], 
            ':users_id' => $data['users_id'] ?? null, 
        ]);

        return (int) $this->pdo->lastInsertId();
    }


    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM newsletter_subscribers WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function deleteByEmail(string $email): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM newsletter_subscribers WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->rowCount() > 0;
    }
}