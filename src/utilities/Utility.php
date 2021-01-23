<?php


class Utility
{
    const USER = "authenticated_user";
    const ADMIN = "admin";

    public static function checkSession(): bool
    {
        session_start();
        if (isset($_SESSION['id'])) {
            return true;
        }
        return false;
    }

    public static function LoginVerify(): void
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            $message = urldecode('You are not logged in. Please log in.');
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login?message=" . $message);
            die;
        }
    }
    public static function isAdmin():bool{
        session_start();
        if($_SESSION['role']===self::ADMIN){
            return true;
        }
        return false;
    }
    public static function setSessionCache(){
        session_cache_limiter('private, must-revalidate');
        session_cache_expire(5);
        session_start();
    }
}