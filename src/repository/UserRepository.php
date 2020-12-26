<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $statement = $this->database->connect()->prepare('
        SELECT * FROM public.users WHERE email = :email');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if($user == false){
            return null; //niewolno tak - exception szeba w security kontrolerze
        }
        return new User($user['email'], $user['login'], $user['password']);
    }

    public function addUser(User $user){
        $login = $user->getLogin();

        $statement2 = $this->database->connect()->prepare('
        INSERT INTO public.users_details(login) VALUES (?)');
        $statement2->execute([$user->getLogin()]);

        $statement3 = $this->database->connect()->prepare('
        SELECT id FROM public.users_details WHERE login = :login
        ');
        $statement3->bindParam(':login',$login,PDO::PARAM_STR);
        $statement3->execute();
        $foundId = $statement3->fetch(PDO::FETCH_ASSOC);

        $statement = $this->database->connect()->prepare('
        INSERT INTO public.users(email, password, users_details_id) VALUES (?,?,?)');
        $statement->execute([$user->getEmail(),$user->getPassword(),$foundId['id']]);
    }
}