<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('login', 'DefaultController');
Router::get('register', 'UserController');
Router::get('updateProfile', 'UserController');
Router::get('myPlants', 'PlantController');
Router::get('waterNow', 'PlantController');

Router::post('plant', 'PlantController');
Router::get('discover', 'PlantController');
Router::post('addPlant', 'PlantController');
Router::post('myPlants', 'PlantController');
Router::post('generalPlant', 'PlantController');
Router::post('editPlant', 'PlantController');
Router::post('search', 'PlantController');
Router::post('login', 'SecurityController');
Router::post('register', 'UserController');
Router::post('updateProfile', 'UserController');

Router::run($path);

