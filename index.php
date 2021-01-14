<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('login', 'DefaultController');
Router::get('register', 'SecurityController');
Router::get('updateProfile', 'UserController');
Router::get('myPlants', 'PlantController');
Router::get('waterNow', 'PlantController');
Router::get('discover', 'GeneralPlantController');

Router::post('plant', 'PlantController');
Router::post('addPlant', 'PlantController');
Router::post('myPlants', 'PlantController');
Router::post('generalPlant', 'GeneralPlantController');
Router::post('editPlant', 'PlantController');
Router::post('search', 'GeneralPlantController');
Router::post('login', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('updateProfile', 'UserController');

Router::run($path);

