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
            return null;
        }
        $plantObj = new Plant($plant['name'], $plant['image']);
        $plantObj->setLastWatered($plant['last_watered']);
        $plantObj->setId($plant['id']);
        $plantObj->setType($plant['plant_id']);
        return $plantObj;
    }

    public function getGeneralPlantById(int $id): ?array
    {
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $plant = $statement->fetch(PDO::FETCH_ASSOC);
        if ($plant == false) {
            return null; //niewolno tak - exception szeba w security kontrolerze
        }
        return $plant;
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

    public function getTypes(): array
    {
        $statement = $this->database->connect()->prepare('
                            SELECT id, type FROM public.plants ORDER BY type');
        $statement->execute();
        $row_list = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row_list;
    }

    public function getTypeByUserPlantId($id): array
    {

        $statement = $this->database->connect()->prepare('SELECT type,plant_id, water_description FROM public.users_plants_view WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $type = $statement->fetch(PDO::FETCH_ASSOC);
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

    public function discoverPlants()
    {
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants ORDER BY type
        ');
        $statement->execute();
        $plantsList = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $plantsList;
    }

    public function getGeneralPlantsByString($string)
    {
        $searchString = strtolower('%' . $string . '%');
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants WHERE lower(type) like :string ORDER BY type
        ');
        $statement->bindParam(':string', $searchString, PDO::PARAM_STR);
        $statement->execute();
        $plantsList = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $plantsList;

    }

    public function editPlant($id,$name, $image, $type ){
        if($image!=null) {
            $statement = $this->database->connect()->prepare('
        UPDATE public.plants_user SET name = :name, image = :image, plant_id = :type WHERE id = :id
        ');
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->bindParam(':type', $type, PDO::PARAM_INT);
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':image', $image, PDO::PARAM_STR);
            $statement->execute();
        }
        else{
            $statement = $this->database->connect()->prepare('
        UPDATE public.plants_user SET name = :name, plant_id = :type WHERE id = :id
        ');
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->bindParam(':type', $type, PDO::PARAM_INT);
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->execute();
        }



    }

}