<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class UserController extends AppController
{
    private UserRepository $userRepository;
    private array $messages = [];

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function updateProfile()
    {
        session_start();
        Utility::LoginVerify();
        if ($this->isPost()) {
            $error = $this->checkEmptyFields();
            if ($error || $_SESSION['login'] != $_POST['login'] || !empty($_POST['password'])) {
                return $this->validateUpdate();
            }
            return $this->updateUser();

        } else {
            return $this->userSettings();
        }
    }

    private function userSettings(string $message = null)
    {
        $user = new User($_SESSION['email'], $_SESSION['login'], null);
        $user->setId($_SESSION['id']);
        $user->setName($_SESSION['name']);
        return $this->render('user-settings', ['messages' => [$message], 'user' => $user]);
    }

    private function validateUpdate()
    {
        if ($_SESSION['login'] != $_POST['login'] && !empty($_POST['login'])) {
            if ($this->userRepository->checkIfLoginExists($_POST['login'])) {
                return $this->userSettings("User with this login already exists!");
            }

        } elseif (!empty($_POST['password'])) {
            if ($_POST['password'] != $_POST['password-confirm']) {
                return $this->userSettings("Provided two different passwords");
            }
        } else {
            return $this->userSettings("name and login inputs can't be empty");
        }
        return $this->updateUser();
    }

    private function checkEmptyFields(): bool
    {
        $array = [
            'name',
            'login',
        ];
        $error = false;
        foreach ($array as $value) {
            if (empty($_POST[$value])) {
                $error = true;
            }
        }
        return $error;
    }

    private function updateUser()
    {
        $this->userRepository->updateUser($_SESSION['id'], $_SESSION['email'], $_POST['login'], $_POST['password'], $_POST['name']);
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['name'] = $_POST['name'];
        return $this->render('main', ['isSession' => Utility::checkSession(), 'isAdmin' => Utility::isAdmin()]);
    }
}