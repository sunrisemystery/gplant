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
        if ($user->getRole() == Utility::ADMIN) {
            $_SESSION['role'] = $user->getRole();
            $_SESSION['id'] = $user->getId();
            return $this->render('admin-view', ['isSession' => Utility::checkSession(), 'userList' => $this->userRepository->getAllUsers()]);
        }

        $_SESSION['email'] = $user->getEmail();
        $_SESSION['login'] = $user->getLogin();
        $_SESSION['name'] = $user->getName();
        $_SESSION['role'] = $user->getRole();
        $_SESSION['id'] = $user->getId();

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

    public function adminView()
    {
        session_start();
        if ($_SESSION['role'] == Utility::ADMIN) {
            if ($this->isPost()) {
                if (isset($_POST['delete-user'])) {
                    $id = $_POST['delete-user'];
                    $this->userRepository->deleteUserById($id);
                }
            }
            return $this->render('admin-view', ['isSession' => Utility::checkSession(), 'userList' => $this->userRepository->getAllUsers()]);
        } else {
            $this->render('main', ['isSession' => Utility::checkSession()]);
        }
    }

    public function searchUser()
    {
        session_start();
        if ($_SESSION['role'] == Utility::ADMIN) {
            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
            if ($contentType === "application/json") {
                $content = trim(file_get_contents("php://input"));
                $decoded = json_decode($content, true);
                header('Content-type: application/json');
                http_response_code(200);
                echo json_encode($this->userRepository->getLoginByString($decoded['search']));
            }
        }
    }
}