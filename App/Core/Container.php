<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use App\Core\Request;

use App\Controllers\UserController;
use App\Controllers\IncidentController;
use App\Controllers\HomeController;

use App\Repository\UserRepository;
use App\Repository\IncidentRepository;
use App\Repository\VillainRepository;

final class Container
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function make(string $class, Request $request): object
    {
        return match ($class) {

            UserController::class => new UserController(
                $request,
                new UserRepository($this->pdo)
            ),

            IncidentController::class => new IncidentController(
                $request,
                new IncidentRepository($this->pdo),
                new VillainRepository($this->pdo)
            ),

            default => new $class($request),
        };
    }
}