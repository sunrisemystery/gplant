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


    public function updateProfile()
    {

        session_start();
        Utility::LoginVerify();

        $array = [
            'name',
            'login',
        ];
        $error = false;
        if ($this->isPost()) {
            foreach ($array as $value) {
                if (empty($_POST[$value])) {
                    $error = true;
                }
            }
            if ($_SESSION['login'] != $_POST['login']) {

                if ($this->userRepository->checkIfLoginExists($_POST['login'])) {

                    return $this->detectedError("User with this login already exists!");
                }
            }
            if (!empty($_POST['password'])) {
                if ($_POST['password'] != $_POST['password-confirm']) {
                    return $this->detectedError("Provided two different passwords");

                }
            }

            if (!$error) {
                $this->userRepository->updateUser($_SESSION['id'], $_SESSION['email'], $_POST['login'], $_POST['password'], $_POST['name']);
                $_SESSION['login'] = $_POST['login'];
                $_SESSION['name'] = $_POST['name'];
                return $this->render('main', ['isSession' => Utility::checkSession(),'isAdmin'=>Utility::isAdmin()]);

            } else {

                return $this->detectedError("name and login inputs cant be empty");
            }

        } else {
            $user = new User($_SESSION['email'], $_SESSION['login'], null);
            $user->setId($_SESSION['id']);
            $user->setName($_SESSION['name']);
            return $this->render('user-settings', ['user' => $user]);
        }


    }

    private function detectedError(string $message)
    {
        session_start();
        $this->messages[] = $message;
        $user = new User($_SESSION['email'], $_SESSION['login'], null);
        $user->setId($_SESSION['id']);
        $user->setName($_SESSION['name']);
        return $this->render('user-settings', ['messages' => $this->messages, 'user' => $user]);
    }
}