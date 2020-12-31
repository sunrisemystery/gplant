<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function login()
    {
        $userRepository = new UserRepository();
        session_start();
        if (!$this->isPost()) {
            session_start();
            if (isset($_SESSION['id'])) {
                session_destroy();
            }
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $userRepository->getUser($email);
        if (!$user) {
            return $this->render('login', ['messages' => ['User with this email doesnt exist!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email doesnt exist!']]);
        }
        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Incorrect password']]);
        }

//        session_start();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['login'] = $user->getLogin();
        $_SESSION['name'] = $user->getName();
        $id = $userRepository->getIdByEmail($user->getEmail());
        $_SESSION['id'] = $id['id'];

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/myPlants");
//        return $this->render('my-plants');


    }
}