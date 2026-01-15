<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

final class VillainRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        // On trie par Alias alphabétique pour l'encyclopédie
        $stmt = $this->pdo->prepare("
            SELECT * FROM villain_profile ORDER BY alias ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM villain_profile WHERE id = :id LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    // Utile pour afficher les vilains par secteur (filtrage encyclopédie)
    public function findBySector(string $sector): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM villain_profile WHERE sector = :sector ORDER BY alias ASC
        ");
        $stmt->execute([':sector' => $sector]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO villain_profile (alias, name, specialty, sector, description, photo_path)
            VALUES (:alias, :name, :specialty, :sector, :description, :photo_path)
        ");

        $stmt->execute([
            ':alias' => $data['alias'],
            ':name' => $data['name'] ?? null, // Peut être NULL si identité inconnue
            ':specialty' => $data['specialty'],
            ':sector' => $data['sector'],
            ':description' => $data['description'],
            ':photo_path' => $data['photo_path']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE villain_profile
            SET alias = :alias,
                name = :name,
                specialty = :specialty,
                sector = :sector,
                description = :description,
                photo_path = :photo_path
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id,
            ':alias' => $data['alias'],
            ':name' => $data['name'] ?? null,
            ':specialty' => $data['specialty'],
            ':sector' => $data['sector'],
            ':description' => $data['description'],
            ':photo_path' => $data['photo_path'],
        ]);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM villain_profile WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}