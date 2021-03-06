<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/GeneralPlant.php';
require_once __DIR__ . '/../repository/GeneralPlantRepository.php';
require_once __DIR__ . '/../utilities/Utility.php';

class GeneralPlantController extends AppController
{
    private GeneralPlantRepository $generalPlantRepository;

    public function __construct()
    {
        parent::__construct();
        $this->generalPlantRepository = new GeneralPlantRepository();
    }

    public function generalPlant()
    {
        Utility::setSessionCache();
        if ($this->isPost()) {
            try {
                $plant = $this->generalPlantRepository->getGeneralPlantById($_POST['general-plant-id']);
            } catch (UnexpectedValueException $e) {
                return $this->discover();
            }
            $generalPlant = new GeneralPlant($plant['type'], $plant['image'], $plant['main_description'], $plant['water_description']);
            return $this->render('general-plant', ['plant' => $generalPlant,
                'isSession' => Utility::checkSession(), 'isAdmin' => Utility::isAdmin()]);
        }
    }

    public function discover()
    {
        return $this->render('discover', ['plantsList' => $this->generalPlantRepository->discoverPlants(),
            'isSession' => Utility::checkSession(), 'isAdmin' => Utility::isAdmin()]);
    }

    public function search()
    {
        $decoded = Utility::search();
        echo json_encode($this->generalPlantRepository->getGeneralPlantsByString($decoded['search']));
    }
}