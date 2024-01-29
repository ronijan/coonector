<?php

declare(strict_types=1);

namespace Ronijan\Connector;

use PDO;

class PdoConnect
{
    public $pdo;

    public $table;

    public function __construct(
        private readonly string $host,
        private readonly string $dbName,
        private readonly string $username,
        private readonly string $password,
        private readonly string $targetTable,
    ) {
        $this->pdo = $this->connect($host, $dbName, $username, $password, $targetTable);
        $this->table = $targetTable;
    }

    private function connect()
    {
        set_exception_handler(function ($e) {
            error_log("# " . $e->getMessage() . "\r\n", 3, __DIR__ . "/.errors.log");
            exit($e->getMessage());
        });

        $dsn = "mysql:host=$this->host;dbname=$this->dbName;charset=utf8mb4";

        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        return new PDO($dsn, "$this->username", "$this->password", $options);
    }
}
