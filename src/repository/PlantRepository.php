<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Plant.php';

class PlantRepository extends Repository
{
    public function getPlantById(int $id): Plant
    {
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants_user WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $plant = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$plant) {
            throw new UnexpectedValueException('Plant not found');
        }
        $plantObj = new Plant($plant['name'], $plant['image']);
        $plantObj->setLastWatered($plant['last_watered']);
        $plantObj->setId($plant['id']);
        $plantObj->setType($plant['plant_id']);
        return $plantObj;
    }

    public function addPlant(Plant $plant): void
    {
        $statement = $this->database->connect()->prepare('
        INSERT INTO public.plants_user( user_id, plant_id, name, image)
        VALUES (?, ?, ?, ?) ');
        $statement->execute([$_SESSION['id'], $plant->getType(), $plant->getName(), $plant->getImage()]);
    }

    public function getPlants(): array
    {
        $result = [];
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants_user WHERE user_id = :user_id ORDER BY name');
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


    public function getTypeByUserPlantId($id): array
    {
        $statement = $this->database->connect()->prepare('
        SELECT 
               p.type, 
               plants_user.plant_id, 
               p.water_description
        FROM public.plants_user 
        LEFT JOIN plants p 
            ON p.id = plants_user.plant_id 
        WHERE plants_user.id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function changeLastWatered($id, $date): void
    {
        $statement = $this->database->connect()->prepare('
        UPDATE public.plants_user SET last_watered = :date WHERE id = :id
        ');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':date', $date);
        $statement->execute();
    }

    public function deletePlantById($id): void
    {
        $statement = $this->database->connect()->prepare('
        DELETE FROM public.plants_user WHERE id = :id
        ');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function editPlant($id, $name, $type, $image = null): void
    {
        if ($image != null) {
            $statement = $this->database->connect()->prepare('
        UPDATE public.plants_user SET name = :name, image = :image, plant_id = :type WHERE id = :id
        ');
            $statement->bindParam(':image', $image);
        } else {
            $statement = $this->database->connect()->prepare('
        UPDATE public.plants_user SET name = :name, plant_id = :type WHERE id = :id
        ');
        }
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':type', $type, PDO::PARAM_INT);
        $statement->bindParam(':name', $name);
        $statement->execute();
    }
}