<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{
    private $userRepository;
    private $messages = [];

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {

        session_start();
        if (!$this->isPost()) {

            session_start();
            if (isset($_SESSION['id'])) {
                unset($_SESSION['id']);
                session_destroy();

            }
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $this->userRepository->getUser($email);
        if (!$user) {
            return $this->render('login', ['messages' => ['User with this email doesnt exist!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email doesnt exist!']]);
        }
        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Incorrect password']]);
        }

        $_SESSION['email'] = $user->getEmail();
        $_SESSION['login'] = $user->getLogin();
        $_SESSION['name'] = $user->getName();
        $id = $this->userRepository->getIdByEmail($user->getEmail());
        $_SESSION['id'] = $id['id'];

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/myPlants");
//        return $this->render('my-plants');


    }

    public function register()
    {
        $error = false;
        $array = ['email',
            'login',
            'password',
            'password-confirm'];
        if ($this->isPost()) {
            foreach ($array as $value) {
                if (empty($_POST[$value])) {
                    $error = true;
                }

            }
            if ($error) {
                $this->messages[] = "All fields are required.";
            } elseif ($this->userRepository->checkIfEmailExists($_POST['email'])) {
                $this->messages[] = "User with this email already exists!";
                return $this->render('register', ['messages' => $this->messages]);
            } elseif ($this->userRepository->checkIfLoginExists($_POST['login'])) {
                $this->messages[] = "User with this login already exists!";
                return $this->render('register', ['messages' => $this->messages]);
            } else {

                $user = new User($_POST['email'], $_POST['login'], $_POST['password']);
                $this->userRepository->addUser($user);
                session_start();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['login'] = $user->getLogin();
                $id = $this->userRepository->getIdByEmail($user->getEmail());
                $_SESSION['id'] = $id['id'];
                $this->messages[] = "Add your first plant here!";
                return $this->render('my-plants', ['messages' => $this->messages]);
            }
            return $this->render('register', ['messages' => $this->messages]);

        }
        return $this->render('register');
    }
}