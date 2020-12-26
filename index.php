<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('login', 'DefaultController');
Router::get('register', 'DefaultController');
Router::get('myPlants', 'PlantController');
Router::get('plant', 'PlantController');
Router::get('discover', 'DefaultController');
Router::post('addPlant', 'PlantController');
Router::post('myPlants', 'PlantController');
Router::post('login', 'SecurityController');
Router::post('register', 'UserController');

Router::run($path);

?>