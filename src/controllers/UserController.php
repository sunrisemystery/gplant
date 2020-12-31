<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class UserController extends AppController
{
    private $userRepository;
    private $messages = [];

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
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

    public function updateProfile()
    {
        session_start();
        $array = ['email',
            'login',
            'password',
            'password-confirm'];
        $error = false;
        if ($this->isPost()) {
            if ($_SESSION['login'] != $_POST['login']) {
                if ($this->userRepository->checkIfLoginExists($_POST['login'])) {
                    $this->messages[] = "User with this login already exists!";
                    $error = true;
                    $user = new User($_SESSION['email'], $_SESSION['login'], null);
                    $user->setId($_SESSION['id']);
                    $user->setName($_SESSION['name']);
                    return $this->render('user-settings', ['messages' => $this->messages, 'user' => $user]);
                }
            }

            if (!$error) {

                $this->userRepository->updateUser($_SESSION['id'], $_SESSION['email'], $_POST['login'], $_POST['password'], $_POST['name']);
                $_SESSION['login'] = $_POST['login'];
                return $this->render('main', ['isSession' => Utility::checkSession()]);

            }

        } else {
            $user = new User($_SESSION['email'], $_SESSION['login'], null);
            $user->setId($_SESSION['id']);
            $user->setName($_SESSION['name']);
            return $this->render('user-settings', ['user' => $user]);
        }
    }

}