<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

final class MovieRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM movies ORDER BY title ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM movies WHERE id = :id LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByHeroId(int $heroProfileId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT m.* FROM movies m
            JOIN hero_profile_has_movies hpm ON m.id = hpm.movies_id
            WHERE hpm.hero_profile_id = :hero_profile_id
            ORDER BY m.title ASC
        ");
        $stmt->execute([':hero_profile_id' => $heroProfileId]);
        return $stmt->fetchAll();
    }

    public function addMovieToHero(int $movieId, int $heroProfileId): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO hero_profile_has_movies (movies_id, hero_profile_id)
            VALUES (:movies_id, :hero_profile_id)
        ");

        $stmt->execute([
            ':movies_id' => $movieId,
            ':hero_profile_id' => $heroProfileId
        ]);

        return $stmt->rowCount() > 0;
    }

    public function removeMovieFromHero(int $movieId, int $heroProfileId): bool
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM hero_profile_has_movies 
            WHERE movies_id = :movies_id AND hero_profile_id = :hero_profile_id
        ");

        $stmt->execute([
            ':movies_id' => $movieId,
            ':hero_profile_id' => $heroProfileId
        ]);

        return $stmt->rowCount() > 0;
    }


    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO movies (title, description, imdb_path, poster_path)
            VALUES (:title, :description, :imdb_path, :poster_path)
        ");

        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':imdb_path' => $data['imdb_path'],
            ':poster_path' => $data['poster_path']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE movies
            SET title = :title,
                description = :description,
                imdb_path = :imdb_path,
                poster_path = :poster_path
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':imdb_path' => $data['imdb_path'],
            ':poster_path' => $data['poster_path'],
        ]);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM movies WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}