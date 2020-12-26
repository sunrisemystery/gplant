<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Plant.php';
require_once __DIR__.'/../repository/PlantRepository.php';

class PlantController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';
    private $messages = [];
    private $plantRepository;


    public function __construct()
    {
        parent::__construct();
        $this->plantRepository = new PlantRepository();
    }

    public function myPlants()
    {
        $id = null;
        if ($this->isPost()) {
            session_start();
            $id = $_SESSION['plant_id'];
            var_dump($id);
            $this->plantRepository->changeLastWatered($id, date("Y-m-d"));
            return $this->render('my-plants', ['messages' => $this->messages, 'plants' => $this->plantRepository->getPlants()]);
        }

        $plants = $this->plantRepository->getPlants();
        $this->render('my-plants', ['plants' => $plants]);

    }

    public function plant()
    {

        $this->render('plant');
    }
    public function addPlant(){
        //'file' is a name of input given in add-plant.php form
        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])){
            move_uploaded_file($_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']);

            $plant = new Plant($_POST['name'], $_FILES['file']['name']);
            $plant->setType(intval($_POST['selectType']));
            $this->plantRepository->addPlant($plant);


            return $this->render('my-plants',['messages'=>$this->messages, 'plants'=>$this->plantRepository->getPlants()]);
        }
        elseif($this->isPost() && strlen($_POST['name'])===0 ){
            $this->messages[] = 'Please fill the name field';
            return $this->render('add-plant',['messages'=>$this->messages, 'rowList'=>$this->plantRepository->getTypes()]);
        }
        elseif ($this->isPost() && strlen($_POST['selectType'])===0 ){
            $this->messages[] = 'Please select type of plant';
            return $this->render('add-plant',['messages'=>$this->messages, 'rowList'=>$this->plantRepository->getTypes()]);
        }
        elseif ($this->isPost() && strlen($_POST['name'])!=0 && strlen($_POST['selectType'])!=0 && is_uploaded_file($_FILES['file']['tmp_name'])==false ){
            $image = $this->plantRepository->getImageFromGeneralPlants(intval($_POST['selectType']));
            $plant = new Plant($_POST['name'], $image);
            $plant->setType(intval($_POST['selectType']));
            $this->plantRepository->addPlant($plant);

            return $this->render('my-plants',['messages'=>$this->messages, 'plants'=>$this->plantRepository->getPlants()]);
        }

         return $this->render('add-plant',['messages'=>$this->messages, 'rowList'=>$this->plantRepository->getTypes()]);
    }

    private function validate(array $file): bool{
        if ($file['size'] > self::MAX_FILE_SIZE){
            $this->messages[] = 'File is too large for destination file system';
            return false;

        }
        if (!isset($file['type']) || !in_array($file['type'],self::SUPPORTED_TYPES) ){
            $this->messages[] = 'File type is not supported';
            return false;

        }
        return true;
    }
    public function types(){

        return $this->render('add-plant',['rowList'=>$this->plantRepository->getTypes()]);

    }
    public function waterNow(){
        $id = null;
        if($this->isPost()){
            $id = $_GET['plant_id'];
            $this->plantRepository->changeLastWatered($id,date("Y-m-d"));
            return $this->render('my-plants',['messages'=>$this->messages, 'plants'=>$this->plantRepository->getPlants()]);

        }
    }

}