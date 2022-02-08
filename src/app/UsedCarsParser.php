<?php


namespace Tapir;


use Exception;

class UsedCarsParser extends CarsParser
{
    private const USED_CARS_URL = 'http://static.tapir.ws/used_cars.xml';

    /**
     * @throws Exception
     */
    public function parse(): void
    {
        $this->parseAndSave();
    }

    /**
     * @throws Exception
     */
    private function parseAndSave()
    {
        $usedCarsXml =  simplexml_load_file(self::USED_CARS_URL);

        $sql = <<<SQL
INSERT INTO cars (hash, brand, model, body_type, engine_type, drive_type, gearbox_type, year, price, mileage, owner_count, is_used) 
VALUES (:hash, :brand, :model, :body_type, :engine_type, :drive_type, :gearbox_type, :year, :price, :mileage, :owner_count, true) 
ON CONFLICT DO NOTHING;
SQL;

        $stmt = $this->pdo->prepare($sql);

        try {
            $this->pdo->beginTransaction();
            foreach ($usedCarsXml as $car) {

                $carArray = [
                    'hash'=>$car['id'],
                    'brand'=>$car->Brand,
                    'model'=>$car->Model,
                    'body_type'=>$car->BodyType,
                    'engine_type'=>$car->EngineType,
                    'drive_type'=>$car->DriveType,
                    'gearbox_type'=>$car->GearboxType,
                    'year'=>$car->Year,
                    'price'=>$car->Price,
                    'mileage'=>$car->Mileage,
                    'owner_count'=>$car->OwnerCount,
                ];

                $stmt->execute($carArray);
            }

            $this->pdo->commit();
        } catch (Exception $exception){
            $this->pdo->rollback();
            throw $exception;
        }
    }
}
