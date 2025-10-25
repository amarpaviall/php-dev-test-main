<?php

namespace silverorange\DevTest;

use PDO;
use PDOException;

class Database
{
    protected ?PDO $pdo = null;
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getConnection(): PDO
    {
        if (!$this->pdo instanceof PDO) {
            try {
                $this->pdo = new PDO(
                    $this->config->dsn,
                    $this->config->user,
                    $this->config->password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                throw new PDOException("Database connection failed: " . $e->getMessage());
            }
        }

        return $this->pdo;
    }
}
