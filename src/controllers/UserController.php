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