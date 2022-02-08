<?php

namespace Tapir;

require_once '../vendor/autoload.php';

try {
    $pdo = (new PDOFactory)->getPDO();
    $newCarParser = new NewCarsParser($pdo);
    $newCarParser->parse();

    $usedCarParser = new UsedCarsParser($pdo);
    $usedCarParser->parse();
} catch (\Throwable $exception) {
    echo $exception->getMessage();
}
