<?php
require_once 'Repository.php';
require_once __DIR__ . '/../models/Plant.php';

class GeneralPlantRepository extends Repository
{
    public function getGeneralPlantById(int $id): ?array
    {
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $plant = $statement->fetch(PDO::FETCH_ASSOC);
        if ($plant == false) {
            return null;
        }
        return $plant;
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

    public function getTypes(): array
    {
        $statement = $this->database->connect()->prepare('
                            SELECT id, type FROM public.plants ORDER BY type');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
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
}