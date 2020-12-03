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
        return new User($user['email'],$user['password'],$user['name'],$user['surname']);
    }
}