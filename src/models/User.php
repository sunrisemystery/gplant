<?php


class User
{
    private $email;
    private $login;
    private $password;
    private $name;
    private $id;
    private $role;

    public function __construct($email, $login, $password)
    {
        $this->email = $email;
        $this->login = $login;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }



    public function getPassword(): string
    {
        return $this->password;
    }



    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getLogin()
    {
        return $this->login;
    }


    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role): void
    {
        $this->role = $role;
    }



}