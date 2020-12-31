<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.users_details_view WHERE email = :email');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user == false) {
            return null; //niewolno tak - exception szeba w security kontrolerze
        }
        $userObj = new User($user['email'], $user['login'], $user['password']);
        $userObj->setName($user['name']);
        return $userObj;
    }

    public function getIdByEmail(string $email)
    {
        $statement = $this->database->connect()->prepare('
        SELECT id FROM public.users WHERE email = :email');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $id = $statement->fetch(PDO::FETCH_ASSOC);
        if ($id == false) {
            return null; //niewolno tak - exception szeba w security kontrolerze
        }
        return $id;
    }

    public function addUser(User $user)
    {
        $login = $user->getLogin();

        $statement2 = $this->database->connect()->prepare('
        INSERT INTO public.users_details(login) VALUES (?)');
        $statement2->execute([$user->getLogin()]);

        $statement3 = $this->database->connect()->prepare('
        SELECT id FROM public.users_details WHERE login = :login
        ');
        $statement3->bindParam(':login', $login, PDO::PARAM_STR);
        $statement3->execute();
        $foundId = $statement3->fetch(PDO::FETCH_ASSOC);

        $statement = $this->database->connect()->prepare('
        INSERT INTO public.users(email, password, users_details_id) VALUES (?,?,?)');
        $statement->execute([$user->getEmail(), $user->getPassword(), $foundId['id']]);
    }

    public function checkIfEmailExists($email): bool
    {
        $statement = $this->database->connect()->prepare('
        SELECT email FROM public.users_details_view WHERE email = :email');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $found = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$found) {
            return false;
        }
        return true;
    }

    public function checkIfLoginExists($login): bool
    {
        $statement = $this->database->connect()->prepare('
        SELECT login FROM public.users_details_view WHERE login = :login');
        $statement->bindParam(':login', $login, PDO::PARAM_STR);
        $statement->execute();
        $found = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$found) {
            return false;
        }
        return true;
    }

    public function updateUser($id, $email, $login, $password, $name)
    {
        if ($password != null) {
            $statement = $this->database->connect()->prepare('
        UPDATE public.users SET  password = :password WHERE id = :id
        ');
            $statement->bindParam(':password', $password, PDO::PARAM_STR);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();

        }

        $statement3 = $this->database->connect()->prepare('
        SELECT users_details_id FROM public.users WHERE email = :email
        ');
        $statement3->bindParam(':email', $email, PDO::PARAM_STR);
        $statement3->execute();
        $foundId = $statement3->fetch(PDO::FETCH_ASSOC);

        $statement2 = $this->database->connect()->prepare('
        UPDATE public.users_details SET login = :login, name = :name WHERE  id = :id
        ');
        $statement2->bindParam(':login', $login, PDO::PARAM_STR);
        $statement2->bindParam(':name', $name, PDO::PARAM_STR);
        $statement2->bindParam(':id', $foundId['users_details_id'], PDO::PARAM_INT);
        $statement2->execute();


    }
}