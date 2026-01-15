<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;
use Exception;

final class IncidentRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT i.*, 
                   a.numero, a.complement_numero, a.street, a.zipcode, a.city,
                   u.firstname AS reporter_firstname, u.lastname AS reporter_lastname, u.email AS reporter_email,
                   v.alias AS villain_alias, v.name AS villain_name
            FROM incidents i
            JOIN adresses_incidents a ON i.adresses_incidents_id = a.id
            JOIN users u ON i.users_id = u.id
            LEFT JOIN villain_profile v ON i.villain_profile_id = v.id
            ORDER BY i.date DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT i.*, 
                   a.numero, a.complement_numero, a.street, a.zipcode, a.city,
                   u.firstname AS reporter_firstname, u.lastname AS reporter_lastname, u.email AS reporter_email,
                   v.alias AS villain_alias, v.name AS villain_name
            FROM incidents i
            JOIN adresses_incidents a ON i.adresses_incidents_id = a.id
            JOIN users u ON i.users_id = u.id
            LEFT JOIN villain_profile v ON i.villain_profile_id = v.id
            WHERE i.id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT i.*, a.city, a.zipcode, v.alias AS villain_alias
            FROM incidents i
            JOIN adresses_incidents a ON i.adresses_incidents_id = a.id
            LEFT JOIN villain_profile v ON i.villain_profile_id = v.id
            WHERE i.users_id = :users_id
            ORDER BY i.date DESC
        ");
        $stmt->execute([':users_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        try {
            $this->pdo->beginTransaction();

            $stmtAddress = $this->pdo->prepare("
                INSERT INTO adresses_incidents (numero, complement_numero, street, zipcode, city)
                VALUES (:numero, :complement_numero, :street, :zipcode, :city)
            ");

            $stmtAddress->execute([
                ':numero' => $data['address_numero'],
                ':complement_numero' => $data['address_complement'] ?? null,
                ':street' => $data['address_street'],
                ':zipcode' => $data['address_zipcode'],
                ':city' => $data['address_city']
            ]);

            $addressId = (int) $this->pdo->lastInsertId();

            $stmtIncident = $this->pdo->prepare("
                INSERT INTO incidents (
                    title, description, date, priority, type, 
                    users_id, villain_profile_id, status, adresses_incidents_id
                )
                VALUES (
                    :title, :description, :date, :priority, :type, 
                    :users_id, :villain_profile_id, :status, :adresses_incidents_id
                )
            ");

            $stmtIncident->execute([
                ':title' => $data['title'],
                ':description' => $data['description'],
                ':date' => $data['date'],
                ':priority' => $data['priority'],
                ':type' => $data['type'],
                ':users_id' => $data['users_id'],
                ':villain_profile_id' => $data['villain_profile_id'] ?? null,
                ':status' => $data['status'],
                ':adresses_incidents_id' => $addressId
            ]);

            $incidentId = (int) $this->pdo->lastInsertId();

            $this->pdo->commit();

            return $incidentId;

        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE incidents
            SET title = :title,
                description = :description,
                date = :date,
                priority = :priority,
                type = :type,
                users_id = :users_id,
                villain_profile_id = :villain_profile_id,
                status = :status
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':date' => $data['date'],
            ':priority' => $data['priority'],
            ':type' => $data['type'],
            ':users_id' => $data['users_id'],
            ':villain_profile_id' => $data['villain_profile_id'] ?? null,
            ':status' => $data['status'],
        ]);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM incidents WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}