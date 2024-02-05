<?php

declare(strict_types=1);

namespace Ronijan\Connector;

use PDO;

final class DbOperations
{
    private string $table;

    public function __construct(
        private readonly PDO $pdo,
        private readonly string $targetTable
    ) {
        $this->table = $targetTable;
    }

    public function find(int $id): mixed
    {
        $query = $this->pdo->prepare("SELECT * FROM `$this->table` WHERE id = :id");

        $query->execute(['id' => $id]);

        return $query->fetch();
    }

    public function findOneBy(array $criteria, array $orderBy = null): mixed
    {
        $criteriaAsString = '';

        foreach ($criteria as $key => $value) {
            $criteriaAsString .= $key . '="' . $value . '" AND ';
        }

        $criteriaAsStringResult = rtrim($criteriaAsString, " AND ");

        $query = $this->pdo->prepare("SELECT * FROM `$this->table` WHERE $criteriaAsStringResult;");

        $query->execute();

        return $query->fetch();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): mixed
    {
        $criteriaAsString = '';

        foreach ($criteria as $key => $value) {
            $criteriaAsString .= $key . '="' . $value . '" AND ';
        }

        $criteriaAsStringResult = rtrim($criteriaAsString, " AND ");

        $query = $this->pdo->prepare("SELECT * FROM `$this->table` WHERE $criteriaAsStringResult;");

        $query->execute();

        return $query->fetchAll();
    }

    public function findAll(): array
    {
        $query = $this->pdo->prepare("SELECT * FROM `$this->table`");

        $query->execute();

        return $query->fetchAll();
    }

    public function query(string $query): mixed
    {
        $query = $this->pdo->prepare("$query");

        $query->execute();

        return $query->fetchAll();
    }

    public function save(array $criteria): bool
    {
        $keysAsString = '';

        foreach (array_keys($criteria) as $key) {
            $keysAsString .= '`' . $key . '`, ';
        }

        $keys = rtrim($keysAsString, ', ');

        $valuesAsString = '';

        foreach (array_values($criteria) as $value) {
            $valuesAsString .=  '"' . $value . '", ';
        }

        $values = rtrim($valuesAsString, ', ');

        $query = $this->pdo->prepare("INSERT INTO `$this->table`($keys) VALUES($values);");

        $query->execute();

        return $query->rowCount() === 1;
    }

    public function remove(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM `$this->table` WHERE id = :id");

        $query->execute(['id' => $id]);

        return $query->rowCount() === 1;
    }
}
