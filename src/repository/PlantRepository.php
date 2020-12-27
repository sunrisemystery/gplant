<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Plant.php';

class PlantRepository extends Repository
{
    public function getPlantById(int $id): ?Plant
    {
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants_user WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $plant = $statement->fetch(PDO::FETCH_ASSOC);
        if ($plant == false) {
            return null; //niewolno tak - exception szeba w security kontrolerze
        }
        $plantObj = new Plant($plant['name'], $plant['image']);
        $plantObj->setLastWatered($plant['last_watered']);
        $plantObj->setId($plant['id']);
        return $plantObj;
    }

    public function addPlant(Plant $plant): void
    {
        session_start();
        $statement = $this->database->connect()->prepare('
        INSERT INTO public.plants_user( user_id, plant_id, name, image)
        VALUES (?, ?, ?, ?) ');
        $statement->execute([$_SESSION['id'], $plant->getType(), $plant->getName(), $plant->getImage()]);

    }

    public function getPlants(): array
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $result = [];
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants_user WHERE user_id = :user_id');
        $statement->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
        $statement->execute();
        $plants = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($plants as $plant) {
            $plantObj = new Plant($plant['name'], $plant['image']);
            $plantObj->setId($plant['id']);
            $plantObj->setLastWatered($plant['last_watered']);
            $result[] = $plantObj;
        }

        return $result;
    }

    public function getTypes(): array
    {
        $statement = $this->database->connect()->prepare('
                            SELECT id, type FROM public.plants');
        $statement->execute();
        $row_list = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row_list;
    }

    public function getTypeByUserPlantId($id): array
    {
        $statement = $this->database->connect()->prepare('
                            SELECT plant_id from public.plants_user WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $plant_id = $statement->fetch(PDO::FETCH_ASSOC);
        $statement2 = $this->database->connect()->prepare('
                            SELECT type from public.plants WHERE id = :id');
        $statement2->bindParam(':id', $plant_id['plant_id'], PDO::PARAM_INT);
        $statement2->execute();
        $type = $statement2->fetch(PDO::FETCH_ASSOC);
        return $type;
    }

    public function getImageFromGeneralPlants($id)
    {
        $statement = $this->database->connect()->prepare('
        SELECT image FROM public.plants WHERE id = :id
        ');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $image = $statement->fetch(PDO::PARAM_STR);
        return $image["image"];
    }

    public function changeLastWatered($id, $date)
    {
        $statement = $this->database->connect()->prepare('
        UPDATE public.plants_user SET last_watered = :date WHERE id = :id
        ');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':date', $date, PDO::PARAM_STR);
        $statement->execute();

    }

    public function deletePlantById($id)
    {
        $statement = $this->database->connect()->prepare('
        DELETE FROM public.plants_user WHERE id = :id
        ');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

}