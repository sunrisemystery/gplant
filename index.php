<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('login', 'DefaultController');
Router::get('register', 'DefaultController');
Router::get('myPlants', 'DefaultController');
Router::get('plant', 'DefaultController');
Router::get('discover', 'DefaultController');
Router::post('login', 'SecurityController');

Router::run($path);

?>