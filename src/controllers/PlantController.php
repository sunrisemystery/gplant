<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Plant.php';
require_once __DIR__ . '/../repository/PlantRepository.php';
require_once __DIR__ . '/../utilities/Utility.php';

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
        session_start();
        $id = null;

        if ($this->isPost()) {
            if (isset($_POST['delete-plant'])) {
                $id = $_POST['delete-plant'];
                $this->plantRepository->deletePlantById($id);
                return $this->render('my-plants', ['messages' => $this->messages, 'plants' => $this->plantRepository->getPlants()]);
            }
        }

        if (!isset($_SESSION['id'])) {
            $this->messages[] = "You are not logged in. Please log in.";
            return $this->render('login', ['messages' => $this->messages]);
        }

        $plants = $this->plantRepository->getPlants();
        if (count($plants) === 0) {
            $this->messages[] = "Add your first plant here!";
            return $this->render('my-plants', ['plants' => $plants, 'messages' => $this->messages]);
        }

        return $this->render('my-plants', ['plants' => $plants]);
    }

    public function waterNow($id)
    {
        $realId = base64_decode($id);
        $this->plantRepository->changeLastWatered($realId, date("Y-m-d"));
        http_response_code(200);

    }

    public function plant()
    {
        session_start();
        if ($this->isPost()) {

            if (isset($_POST['plant-id'])) {
                $id = $_POST['plant-id'];
                $plant = $this->plantRepository->getPlantById($id);
                $data = $this->plantRepository->getTypeByUserPlantId($id);
                return $this->render('plant', ['plant' => $plant, 'data' => $data]);
            }

            if (isset($_POST['update-button'])) {

                $id = $_POST['update-button'];
                $type = intval($_POST['selectType']);
                $name = $_POST['name'];
                if (empty($name) || empty($type)) {
                    $this->messages[] = "All fields are required.";
                    return $this->render('edit-plant', ['rowList' => $this->plantRepository->getTypes(), 'plantType' => $this->plantRepository->getTypeByUserPlantId($id), 'plant' => $this->plantRepository->getPlantById($id), 'messages' => $this->messages]);
                }

                if (is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {

                    move_uploaded_file(
                        $_FILES['file']['tmp_name'],
                        dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
                    );
                    $image = $_FILES['file']['name'];
                    $this->plantRepository->editPlant($id, $name, $image, $type);
                    $plant = $this->plantRepository->getPlantById($id);
                    $data = $this->plantRepository->getTypeByUserPlantId($id);
                    return $this->render('plant', ['plant' => $plant, 'data' => $data]);
                } else {

                    $this->plantRepository->editPlant($id, $name, null, $type);
                    $plant = $this->plantRepository->getPlantById($id);
                    $data = $this->plantRepository->getTypeByUserPlantId($id);
                    return $this->render('plant', ['plant' => $plant, 'data' => $data]);
                }
            }
        }
    }

    public function generalPlant()
    {
        if ($this->isPost()) {
            $id = $_POST['general-plant-id'];
            $plant = $this->plantRepository->getGeneralPlantById($id);
            return $this->render('general-plant', ['plant' => $plant, 'isSession' => Utility::checkSession()]);
        }
    }

    public function discover()
    {
        return $this->render('discover', ['plantsList' => $this->plantRepository->discoverPlants(), 'isSession' => Utility::checkSession()]);
    }

    public function addPlant()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            $plant = new Plant($_POST['name'], $_FILES['file']['name']);
            $plant->setType(intval($_POST['selectType']));
            $this->plantRepository->addPlant($plant);
            return $this->render('my-plants', ['messages' => $this->messages, 'plants' => $this->plantRepository->getPlants()]);
        } elseif ($this->isPost() && strlen($_POST['name']) === 0) {

            $this->messages[] = 'Please fill the name field';
            return $this->render('add-plant', ['messages' => $this->messages, 'rowList' => $this->plantRepository->getTypes()]);
        } elseif ($this->isPost() && strlen($_POST['selectType']) === 0) {

            $this->messages[] = 'Please select type of plant';
            return $this->render('add-plant', ['messages' => $this->messages, 'rowList' => $this->plantRepository->getTypes()]);
        } elseif ($this->isPost() && strlen($_POST['name']) != 0 && strlen($_POST['selectType']) != 0 && is_uploaded_file($_FILES['file']['tmp_name']) == false) {

            $image = $this->plantRepository->getImageFromGeneralPlants(intval($_POST['selectType']));
            $plant = new Plant($_POST['name'], $image);
            copy('public/img/discover/'.$image, 'public/uploads/'.$image);
            $plant->setType(intval($_POST['selectType']));
            $this->plantRepository->addPlant($plant);
            return $this->render('my-plants', ['messages' => $this->messages, 'plants' => $this->plantRepository->getPlants()]);
        }
        session_start();
        if (!isset($_SESSION['id'])) {
            $this->messages[] = "You are not logged in. Please log in.";
            return $this->render('login', ['messages' => $this->messages]);
        }
        return $this->render('add-plant', ['messages' => $this->messages, 'rowList' => $this->plantRepository->getTypes()]);
    }

    public function editPlant()
    {
        if ($this->isPost() && isset($_POST['update-plant'])) {
            return $this->render('edit-plant', ['rowList' => $this->plantRepository->getTypes(), 'plantType' => $this->plantRepository->getTypeByUserPlantId($_POST['update-plant']), 'plant' => $this->plantRepository->getPlantById($_POST['update-plant'])]);
        }
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');
            http_response_code(200);
            echo json_encode($this->plantRepository->getGeneralPlantsByString($decoded['search']));
        }
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File is too large for destination file system';
            return false;
        }
        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'File type is not supported';
            return false;
        }
        return true;
    }
}
