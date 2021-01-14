<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/GeneralPlant.php';
require_once __DIR__ . '/../repository/GeneralPlantRepository.php';
require_once __DIR__ . '/../utilities/Utility.php';

class GeneralPlantController extends AppController
{

    private $generalPlantRepository;
    public function __construct()
    {
        parent::__construct();
        $this->generalPlantRepository = new GeneralPlantRepository();
    }

    public function generalPlant()
    {
        session_cache_limiter('private, must-revalidate');
        session_cache_expire(5);
        session_start();
        if ($this->isPost()) {
            $id = $_POST['general-plant-id'];
            $plant = $this->generalPlantRepository->getGeneralPlantById($id);
            $generalPlant = new GeneralPlant($plant['type'],$plant['image'],$plant['main_description'],$plant['water_description']);
            return $this->render('general-plant', ['plant' => $generalPlant, 'isSession' => Utility::checkSession()]);
        }
    }
    public function discover()
    {
        return $this->render('discover', ['plantsList' => $this->generalPlantRepository->discoverPlants(), 'isSession' => Utility::checkSession()]);
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');
            http_response_code(200);
            echo json_encode($this->generalPlantRepository->getGeneralPlantsByString($decoded['search']));
        }
    }
}