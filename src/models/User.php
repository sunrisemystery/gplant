<?php


class User
{
    private $email;
    private $login;
    private $password;
    private $id;

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


    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


    public function setPassword(string $password)
    {
        $this->password = $password;
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

    public function setLogin($login): void
    {
        $this->login = $login;
    }









}