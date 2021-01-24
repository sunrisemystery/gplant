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

    public static function isAdmin(): bool
    {
        session_start();
        if ($_SESSION['role'] === self::ADMIN) {
            return true;
        }
        return false;
    }

    public static function setSessionCache()
    {
        session_cache_limiter('private, must-revalidate');
        session_cache_expire(1);
        session_start();
    }

    public static function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');
            http_response_code(200);
            return $decoded;
        }
    }
}