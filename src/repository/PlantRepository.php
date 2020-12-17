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
        INSERT INTO public.plants_user( user_id, plant_id, name, last_watered, image)
        VALUES (?, ?, ?, ?, ?) ');
        //odczytac id za pomocą sesji
        $user_id = 1;
        $plant_id = 1;
        $statement->execute([$user_id, $plant_id, $plant->getName(), $plant->getLastWatered(), $plant->getImage()]);

    }
    public function getPlants(): array
    {
        $result = [];
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.plants_user');
        $statement->execute();
        $plants = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($plants as $plant){

            $result[] = new Plant(
                $plant['name'],
                $plant['image']
            );
        }

        return $result;
    }

}