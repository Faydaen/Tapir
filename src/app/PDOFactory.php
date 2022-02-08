<?php

namespace Tapir;

use PDO;
use PDOException;

final class PDOFactory
{
    private const HOST = 'tapir_db';
    private const DATABASE = 'tapir';
    private const PORT = '5432';
    private const USER = 'tapir';
    private const PASSWORD = 'qwerty';

    private PDO $pdo;

    public function __construct()
    {
        $this->connect();
    }

    public function __invoke(): PDO
    {
        return $this->getPdo();
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    private function connect()
    {
        try {
            $dsn = 'pgsql:host=' . self::HOST . ';port=' . self::PORT . ';dbname=' . self::DATABASE . ';';
            $this->pdo = new PDO($dsn, self::USER, self::PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $exception) {
            throw $exception;
        }
    }
}
