<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): User
    {
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.users_details_view WHERE email = :email');
        $statement->bindParam(':email', $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            throw new UnexpectedValueException("User with this email doesn't exist");
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
        $statement->bindParam(':role', $role);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdByEmail(string $email): array
    {
        $statement = $this->database->connect()->prepare('
        SELECT id FROM public.users WHERE email = :email');
        $statement->bindParam(':email', $email);
        $statement->execute();
        $id = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$id) {
            throw new UnexpectedValueException('id not found');
        }
        return $id;
    }

    public function addUser(User $user): void
    {
        $this->addUserDetails($user->getLogin());
        $foundId = $this->findUserIdByLogin($user->getLogin());
        $statement = $this->database->connect()->prepare('
        INSERT INTO public.users(email, password, users_details_id) VALUES (?,?,?)');
        $statement->execute([$user->getEmail(), password_hash($user->getPassword(), PASSWORD_DEFAULT), $foundId['id']]);
    }

    public function deleteUserById($id): void
    {
        $foundId = $this->findUserDetailsIdByUserId($id);
        if ($foundId == false) {
            throw new UnexpectedValueException('User not found');
        }
        $statement = $this->database->connect()->prepare('
        DELETE FROM public.users_details WHERE id = :id');
        $statement->bindParam(':id', $foundId['users_details_id'], PDO::PARAM_INT);
        $statement->execute();
    }

    public function getLoginByString(string $string): array
    {
        $searchString = strtolower('%' . $string . '%');
        $role = Utility::USER;
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.users_details_view WHERE lower(login) like :string AND  role like :role ORDER BY login
        ');
        $statement->bindParam(':string', $searchString);
        $statement->bindParam(':role', $role);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkIfEmailExists(string $email): bool
    {
        $statement = $this->database->connect()->prepare('
        SELECT email FROM public.users_details_view WHERE email = :email');
        $statement->bindParam(':email', $email);
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
        $statement->bindParam(':login', $login);
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
            $this->setUserPassword($id, $password);
        }
        $foundId = $this->findUserDetailsIdByEmail($email);
        $statement = $this->database->connect()->prepare('
        UPDATE public.users_details SET login = :login, name = :name WHERE  id = :id
        ');
        $statement->bindParam(':login', $login);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':id', $foundId['users_details_id'], PDO::PARAM_INT);
        $statement->execute();
    }

    private function findUserIdByLogin($login)
    {
        $statement = $this->database->connect()->prepare('
        SELECT id FROM public.users_details WHERE login = :login
        ');
        $statement->bindParam(':login', $login);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    private function findUserDetailsIdByUserId($id)
    {
        $statement = $this->database->connect()->prepare('
        SELECT users_details_id FROM public.users WHERE id = :id
        ');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    private function findUserDetailsIdByEmail($email)
    {
        $statement = $this->database->connect()->prepare('
        SELECT users_details_id FROM public.users WHERE email = :email
        ');
        $statement->bindParam(':email', $email);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    private function setUserPassword($id, $password)
    {
        $statement = $this->database->connect()->prepare('
        UPDATE public.users SET  password = :password WHERE id = :id
        ');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $statement->bindParam(':password', $passwordHash);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    private function addUserDetails($login)
    {
        $statement = $this->database->connect()->prepare('
        INSERT INTO public.users_details(login) VALUES (?)');
        $statement->execute([$login]);
    }

}