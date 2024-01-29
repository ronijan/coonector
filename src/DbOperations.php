<?php

declare(strict_types=1);

namespace Ronijan\Connector;

use PDO;

final class DbOperations
{
    public function __construct(private readonly PDO $pdo, private string $targettargetTable)
    {
        $this->targetTable = $targettargetTable;
    }

    public function findById(int $id): DbOperations
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->targetTable WHERE id = ?");
        $stmt->execute([$id]);
        $stmt = null;

        return $this;
    }

    public function findAll(): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->targetTable");
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$arr) return false;
        $stmt = null;

        return $arr;
    }

    public function deleteById(int $id): DbOperations
    {
        $stmt = $this->pdo->prepare("DELETE FROM $this->targetTable WHERE id = ?");
        $stmt->execute([$id]);
        $stmt = null;

        return $this;
    }
}
