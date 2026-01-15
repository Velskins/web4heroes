<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

final class UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users ORDER BY id ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users WHERE id = :id LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findOneByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users WHERE email = :email LIMIT 1
        ");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (
                email, pwd, lastname, firstname, gender, birthdate, phone, 
                street_number, complement_number, street, zipcode, city, role
            )
            VALUES (
                :email, :pwd, :lastname, :firstname, :gender, :birthdate, :phone, 
                :street_number, :complement_number, :street, :zipcode, :city, :role
            )
        ");

        $stmt->execute([
            ':email' => $data['email'],
            ':pwd' => $data['pwd'],
            ':lastname' => $data['lastname'],
            ':firstname' => $data['firstname'],
            ':gender' => $data['gender'],
            ':birthdate' => $data['birthdate'],
            ':phone' => $data['phone'] ?? null,
            ':street_number' => $data['street_number'] ?? null,
            ':complement_number' => $data['complement_number'] ?? null,
            ':street' => $data['street'] ?? null,
            ':zipcode' => $data['zipcode'] ?? null,
            ':city' => $data['city'] ?? null,
            ':role' => $data['role']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users
            SET email = :email,
                pwd = :pwd,
                lastname = :lastname,
                firstname = :firstname,
                gender = :gender,
                birthdate = :birthdate,
                phone = :phone,
                street_number = :street_number,
                complement_number = :complement_number,
                street = :street,
                zipcode = :zipcode,
                city = :city,
                role = :role
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id,
            ':email' => $data['email'],
            ':pwd' => $data['pwd'],
            ':lastname' => $data['lastname'],
            ':firstname' => $data['firstname'],
            ':gender' => $data['gender'],
            ':birthdate' => $data['birthdate'],
            ':phone' => $data['phone'] ?? null,
            ':street_number' => $data['street_number'] ?? null,
            ':complement_number' => $data['complement_number'] ?? null,
            ':street' => $data['street'] ?? null,
            ':zipcode' => $data['zipcode'] ?? null,
            ':city' => $data['city'] ?? null,
            ':role' => $data['role'],
        ]);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}