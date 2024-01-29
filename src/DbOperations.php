<?php

declare(strict_types=1);

namespace Ronijan\Connector;

use PDO;

final class DbOperations
{
    private string $table;

    public function __construct(
        private readonly PDO $pdo,
        private readonly string $targettargetTable)
    {
        $this->table = $targettargetTable;
    }

    public function findById(int $id): mixed
    {
        $query = $this->pdo->prepare("SELECT * FROM `$this->table` WHERE id = :id");

        $query->execute(['id' => $id]);

        return $query->fetch();
    }

    public function findAll(): array
    {
        $query = $this->pdo->prepare("SELECT * FROM `$this->table`");

        $query->execute();

        return $query->fetchAll();
    }

    public function deleteById(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM `$this->table` WHERE id = :id");

        $query->execute(['id' => $id]);

        return $query->rowCount() === 1;
    }
}
