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
            return null;
        }
        $userObj = new User($user['email'], $user['login'], $user['password']);
        $userObj->setName($user['name']);
        $userObj->setRole($user['role']);
        $userObj->setId($user['id']);
        return $userObj;
    }

    public function getAllUsers(): array
    {
        $role = Utility::USER;
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.users_details_view WHERE role = :role ORDER BY login');
        $statement->bindParam(':role', $role, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdByEmail(string $email): ?array
    {
        $statement = $this->database->connect()->prepare('
        SELECT id FROM public.users WHERE email = :email');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $id = $statement->fetch(PDO::FETCH_ASSOC);
        if ($id == false) {
            return null;
        }
        return $id;
    }

    public function addUser(User $user): void
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
        $statement->execute([$user->getEmail(), password_hash($user->getPassword(), PASSWORD_DEFAULT), $foundId['id']]);
    }

    public function deleteUserById($id): void
    {
        $statement = $this->database->connect()->prepare('
        SELECT users_details_id FROM public.users WHERE id = :id
        ');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $foundId = $statement->fetch(PDO::FETCH_ASSOC);
        $statement2 = $this->database->connect()->prepare('
        DELETE FROM public.users_details WHERE id = :id');
        $statement2->bindParam(':id', $foundId['users_details_id'], PDO::PARAM_INT);
        $statement2->execute();
    }

    public function getLoginByString(string $string): array
    {
        $searchString = strtolower('%' . $string . '%');
        $role = Utility::USER;
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.users_details_view WHERE lower(login) like :string AND  role like :role ORDER BY login
        ');
        $statement->bindParam(':string', $searchString, PDO::PARAM_STR);
        $statement->bindParam(':role', $role, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function checkIfEmailExists(string $email): bool
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

    public function checkIfLoginExists(string $login): bool
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
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $statement->bindParam(':password', $passwordHash, PDO::PARAM_STR);
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