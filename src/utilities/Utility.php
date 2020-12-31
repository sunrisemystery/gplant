<?php


class Utility
{

    public static function checkSession():bool{
        session_start();
        if(isset($_SESSION['id'])){
            return true;
        }
        return false;
    }

}