<?php


class Utility
{

    public static function checkSession(): bool
    {
        session_start();
        if (isset($_SESSION['id'])) {
            return true;
        }
        return false;
    }

    public static function LoginVerify()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            $message = urldecode('You are not logged in. Please log in.');
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login?message=" . $message);
            die;
        }
    }

}