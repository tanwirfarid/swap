<?php

class EnterCheck
{
    static function has_entered($enter)
    {
        if (!isset($_SESSION["entered"])) {
            session_start();
            $_SESSION["entered"] = false;
            header("Location: ./landing.php" . ($enter == "") ? "?enter=" . $enter : "");
        } else if (!$_SESSION["entered"]) {
            header("Location: ./landing.php");
        }
    }
}