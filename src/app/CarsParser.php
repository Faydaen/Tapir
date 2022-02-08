<?php


namespace Tapir;

use PDO;

abstract class CarsParser implements IParser
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}
