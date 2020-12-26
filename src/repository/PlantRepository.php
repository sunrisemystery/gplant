<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Plant.php';
class PlantRepository extends Repository
{
    public function getPlant(int $id): ?Plant
    {
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $plant = $statement->fetch(PDO::FETCH_ASSOC);
        if($plant == false){
            return null; //niewolno tak - exception szeba w security kontrolerze
        }

        return new Plant($plant['name'],$plant['image']);
    }

    public function addPlant(Plant $plant): void{

        $statement = $this->database->connect()->prepare('
        INSERT INTO public.plants_user( user_id, plant_id, name, image)
        VALUES (?, ?, ?, ?) ');
        //odczytac id za pomocą sesji
        $user_id = 2;
        $statement->execute([$user_id, $plant->getType(), $plant->getName(), $plant->getImage()]);

    }
    public function getPlants(): array
    {
        $result = [];
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants_user');
        $statement->execute();
        $plants = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($plants as $plant){
            $plantObj = new Plant($plant['name'],$plant['image']);
            $plantObj->setId($plant['id']);
            $plantObj->setLastWatered($plant['last_watered']);
            $result[] = $plantObj;
        }

        return $result;
    }
    public function getTypes(): array{
        $statement = $this->database->connect()->prepare('
                            SELECT id, type FROM public.plants' );
        $statement->execute();
        $row_list = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row_list;
    }

    public function getImageFromGeneralPlants($id){
        $statement = $this->database->connect()->prepare('
        SELECT image FROM public.plants WHERE id = :id
        ');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $image = $statement->fetch(PDO::PARAM_STR);
        return $image["image"];
    }
    public function changeLastWatered($id, $date){
        $statement = $this->database->connect()->prepare('
        UPDATE public.plants_user SET last_watered = :date WHERE id = :id
        ');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':date', $date, PDO::PARAM_STR);
        $statement->execute();

    }

}