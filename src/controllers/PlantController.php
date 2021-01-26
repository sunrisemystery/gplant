<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Plant.php';
require_once __DIR__ . '/../repository/PlantRepository.php';
require_once __DIR__ . '/../repository/GeneralPlantRepository.php';
require_once __DIR__ . '/../utilities/Utility.php';

class PlantController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';
    private array $messages = [];
    private PlantRepository $plantRepository;
    private GeneralPlantRepository $generalPlantRepository;

    public function __construct()
    {
        parent::__construct();
        $this->plantRepository = new PlantRepository();
        $this->generalPlantRepository = new GeneralPlantRepository();
    }

    public function myPlants()
    {
        Utility::setSessionCache();
        Utility::LoginVerify();
        if (Utility::isAdmin()) {
            return $this->render('main', ['isSession' => Utility::checkSession(),
                'isAdmin' => Utility::isAdmin()]);
        }
        if (isset($_POST['delete-plant'])) {
            return $this->deletePlant();
        }
        $plants = $this->plantRepository->getPlants();
        if (count($plants) === 0) {
            $this->messages[] = "Add your first plant here!";
        }
        return $this->render('my-plants', ['plants' => $plants, 'messages' => $this->messages]);
    }

    public function waterNow($id)
    {
        session_start();
        Utility::LoginVerify();
        $realId = base64_decode($id);
        $this->plantRepository->changeLastWatered($realId, date("Y-m-d"));
        http_response_code(200);
    }

    public function plant()
    {
        Utility::setSessionCache();
        Utility::LoginVerify();
        if (isset($_POST['update-button'])) {
            return $this->plantAfterUpdate();
        }
        if (isset($_POST['plant-id'])) {
            try {
                return $this->render('plant', ['plant' => $this->plantRepository->getPlantById($_POST['plant-id']),
                    'data' => $this->plantRepository->getTypeByUserPlantId($_POST['plant-id']),
                    'isSession' => Utility::checkSession()]);
            } catch (UnexpectedValueException $e) {
                return $this->addPlantCriticalMessage($e->getMessage() . '. You can add it here');
            }
        }
    }

    public function addPlant()
    {
        Utility::setSessionCache();
        Utility::LoginVerify();
        if (Utility::isAdmin()) {
            return $this->render('main', ['isSession' => Utility::checkSession(), 'isAdmin' => Utility::isAdmin()]);
        }
        if ($this->isPost()) {
            if (strlen($_POST['name']) === 0 || strlen($_POST['selectType']) === 0) {
                return $this->checkEmptyField($_POST['name'], $_POST['selectType']);
            }
            return $this->checkImage();
        }
        return $this->render('add-plant', ['rowList' => $this->generalPlantRepository->getTypes()]);
    }

    public function editPlant()
    {
        Utility::setSessionCache();
        Utility::LoginVerify();
        if (Utility::isAdmin()) {
            return $this->render('main', ['isSession' => Utility::checkSession(), 'isAdmin' => Utility::isAdmin()]);
        }
        if (isset($_POST['update-plant'])) {
            try {
                return $this->render('edit-plant', ['rowList' => $this->generalPlantRepository->getTypes(),
                    'plantType' => $this->plantRepository->getTypeByUserPlantId($_POST['update-plant']),
                    'plant' => $this->plantRepository->getPlantById($_POST['update-plant'])]);
            } catch (UnexpectedValueException $e) {
                return $this->addPlantCriticalMessage($e->getMessage() . '. You can add it here');
            }
        }
    }

    private function addPlantCriticalMessage($message)
    {
        return $this->render('add-plant', ['messages' => [$message], 'rowList' => $this->generalPlantRepository->getTypes()]);
    }

    private function editPlantEmptyFieldMessage($message, $id)
    {
        try {
            return $this->render('edit-plant', ['rowList' => $this->generalPlantRepository->getTypes(),
                'plantType' => $this->plantRepository->getTypeByUserPlantId($id), 'plant' => $this->plantRepository->getPlantById($id),
                'messages' => [$message]]);
        } catch (UnexpectedValueException $e) {
            return $this->addPlantCriticalMessage($e->getMessage() . '. You can add it here');
        }
    }

    private function checkEmptyField($name, $type)
    {
        if (strlen($name) === 0) {
            return $this->addPlantCriticalMessage('Please fill the name field');
        } elseif (strlen($type) === 0) {
            return $this->addPlantCriticalMessage('Please select type of plant');
        }
    }

    private function plantAfterUpdate()
    {
        $id = $_POST['update-button'];
        $type = intval($_POST['selectType']);
        $name = $_POST['name'];
        if (empty($name) || empty($type)) {
            return $this->editPlantEmptyFieldMessage("All fields are required.", $id);
        }
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            if ($this->validate($_FILES['file'])) {
                $this->moveUploadedFile();
                $this->plantRepository->editPlant($id, $name, $type, $_FILES['file']['name']);
                return $this->getPlant($id);
            }
            return $this->editPlantEmptyFieldMessage("File is too large.", $id);
        } else {
            $this->plantRepository->editPlant($id, $name, $type);
            return $this->getPlant($id);
        }
    }

    private function getPlant($id)
    {
        try {
            return $this->render('plant', ['plant' => $this->plantRepository->getPlantById($id),
                'data' => $this->plantRepository->getTypeByUserPlantId($id), 'isSession' => Utility::checkSession()]);
        } catch (UnexpectedValueException $e) {
            return $this->addPlantCriticalMessage($e->getMessage() . '. You can add it here');
        }
    }

    private function deletePlant()
    {
        $this->plantRepository->deletePlantById($_POST['delete-plant']);
        return $this->render('my-plants', ['plants' => $this->plantRepository->getPlants()]);
    }

    private function checkImage()
    {
        if (is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {

            $this->moveUploadedFile();
            return $this->addPlantWithImage(new Plant($_POST['name'], $_FILES['file']['name']));
        }
        if (is_uploaded_file($_FILES['file']['tmp_name']) == false) {

            $image = $this->generalPlantRepository->getImageFromGeneralPlants(intval($_POST['selectType']));
            copy('public/img/discover/' . $image, 'public/uploads/' . $image);
            return $this->addPlantWithImage(new Plant($_POST['name'], $image));
        }
    }

    private function addPlantWithImage($plant)
    {
        $plant->setType(intval($_POST['selectType']));
        $this->plantRepository->addPlant($plant);
        return $this->render('my-plants', ['messages' => $this->messages, 'plants' => $this->plantRepository->getPlants()]);
    }

    private function moveUploadedFile()
    {
        move_uploaded_file(
            $_FILES['file']['tmp_name'],
            dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
        );
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
