<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
/*
use App\Controllers\CategoryController;
use App\Controllers\ProductController;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
*/
final class Container
{
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function make(string $class, Request $request): object
    {
        return match ($class) {
            /*
            ProductController::class => new ProductController(
                $request,
                new ProductRepository($this->pdo),
                new CategoryRepository($this->pdo)
            ),

            CategoryController::class => new CategoryController(
                $request,
                new CategoryRepository($this->pdo)
            ), 
            */

            default => new $class($request),
        };
    }
}
