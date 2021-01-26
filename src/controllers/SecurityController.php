<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../utilities/Utility.php';

class SecurityController extends AppController
{
    private UserRepository $userRepository;
    private array $messages = [];

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        session_start();
        if (!$this->isPost()) {
            $this->destroySession();
            return $this->render('login');
        }

        $email = strtolower($_POST["email"]);
        try {
            $user = $this->userRepository->getUser($email);
        } catch (UnexpectedValueException $e) {
            return $this->pageMessage('login', $e->getMessage());
        }

        if ($user->getEmail() !== $email || !password_verify($_POST["password"], $user->getPassword())) {
            return $this->validateUser($user);
        }

        if ($user->getRole() == Utility::ADMIN) {
            $_SESSION['role'] = $user->getRole();
            $_SESSION['id'] = $user->getId();
            return $this->render('admin-view', ['isSession' => Utility::checkSession(),
                'userList' => $this->userRepository->getAllUsers()]);
        }
        $this->setSessionFields($user);
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/myPlants");
    }

    public function register()
    {
        if ($this->isPost()) {
            session_start();
            $error = $this->checkEmptyFields();
            if ($error || $this->userRepository->checkIfEmailExists($_POST['email']) ||
                $this->userRepository->checkIfLoginExists($_POST['login']) ||
                $_POST["password"] != $_POST["password-confirm"]) {

                return $this->validateRegistration();
            }
            $user = new User($_POST['email'], $_POST['login'], $_POST['password']);
            $this->userRepository->addUser($user);
            try {
                $id = $this->userRepository->getIdByEmail($user->getEmail());
            } catch (UnexpectedValueException $e) {
                return $this->pageMessage('register', $e->getMessage());
            }
            $user->setId($id['id']);
            $user->setRole(Utility::USER);
            $this->setSessionFields($user);
            return $this->pageMessage('my-plants', "Add your first plant here!");
        }
        return $this->render('register');
    }

    public function adminView()
    {
        Utility::setSessionCache();
        if ($_SESSION['role'] == Utility::ADMIN) {
            if (isset($_POST['delete-user'])) {
                try {
                    $this->userRepository->deleteUserById($_POST['delete-user']);
                } catch (UnexpectedValueException $e) {
                    return $this->render('admin-view', ['isSession' => Utility::checkSession(),
                        'userList' => $this->userRepository->getAllUsers()]);
                }
            }
            return $this->render('admin-view', ['isSession' => Utility::checkSession(),
                'userList' => $this->userRepository->getAllUsers()]);
        }
        $this->render('main', ['isSession' => Utility::checkSession(), 'isAdmin' => Utility::isAdmin()]);
    }

    public function searchUser()
    {
        session_start();
        if (Utility::isAdmin()) {
            $decoded = Utility::search();
            echo json_encode($this->userRepository->getLoginByString($decoded['search']));
        }
    }

    private function destroySession()
    {
        if (isset($_SESSION['id'])) {
            unset($_SESSION['id']);
            session_destroy();
        }
    }

    private function validateRegistration()
    {
        if ($_POST["password"] != $_POST["password-confirm"]) {
            return $this->pageMessage('register', "Provided two different passwords");
        } elseif ($this->userRepository->checkIfEmailExists($_POST['email'])) {
            return $this->pageMessage('register', "User with this email already exists!");
        } elseif ($this->userRepository->checkIfLoginExists($_POST['login'])) {
            return $this->pageMessage('register', "User with this login already exists!");
        } elseif (!preg_match('/\S+@\S+\.\S+/', $_POST['email']) && !empty($_POST['email'])) {
            return $this->pageMessage('register', "Provided string is not an email");
        }
        return $this->pageMessage('register', 'All fields are required');
    }

    private function pageMessage($pageName, $message)
    {
        return $this->render($pageName, ['messages' => [$message]]);
    }

    private function validateUser($user)
    {
        if ($user->getEmail() !== $_POST["email"]) {
            return $this->pageMessage('login', "User with this email doesn't exist!");
        } elseif (!password_verify($_POST["password"], $user->getPassword())) {
            return $this->pageMessage('login', 'Incorrect password!');
        }
    }

    private function setSessionFields($user)
    {
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['login'] = $user->getLogin();
        $_SESSION['name'] = $user->getName();
        $_SESSION['role'] = $user->getRole();
        $_SESSION['id'] = $user->getId();
    }

    private function checkEmptyFields(): bool
    {
        $error = false;
        $array = ['email',
            'login',
            'password',
            'password-confirm'];
        foreach ($array as $value) {
            if (empty($_POST[$value])) {
                $error = true;
            }
        }
        if (!preg_match('/\S+@\S+\.\S+/', $_POST['email'])) {
            $error = true;
        }
        return $error;
    }
}