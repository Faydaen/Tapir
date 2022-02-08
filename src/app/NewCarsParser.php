<?php

namespace Tapir;

use Exception;

class NewCarsParser extends CarsParser
{
    private const NEW_CARS_URL = 'http://static.tapir.ws/new_cars.json';

    /**
     * @var string
     */
    private string $jsonData;

    private array $cars;

    /**
     * @throws Exception
     */
    public function parse(): void
    {
        $this->getData();
        $this->parseData();
        $this->saveDataToDB();
    }

    /**
     * @throws Exception
     */
    private function getData()
    {
        $jsonData = file_get_contents(self::NEW_CARS_URL);
        if ($jsonData === false) {
            throw new Exception('Can\'t read from url ' . self::NEW_CARS_URL);
        }
        $this->jsonData = $jsonData;
    }

    private function parseData()
    {
        $this->cars = json_decode($this->jsonData, true);
    }

    private function saveDataToDB()
    {
        $sql = <<<SQL
INSERT INTO cars (hash, brand, model, vin, body_type, engine_type, drive_type, gearbox_type, year, price, is_used) 
VALUES (:id, :brand, :model, :vin, :body_type, :engine_type, :drive_type, :gearbox_type, :year, :price, false) 
ON CONFLICT DO NOTHING;
SQL;

        $stmt = $this->pdo->prepare($sql);

        try {
            $this->pdo->beginTransaction();
            foreach ($this->cars as $car) {
                $stmt->execute($car);
            }
            $this->pdo->commit();
        } catch (Exception $exception) {
            $this->pdo->rollback();
            throw $exception;
        }
    }
}