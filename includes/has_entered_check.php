<?php
if (!isset($_COOKIE["entered"])) {
    setcookie("entered", false, time() + 60 * 60 * 24 * 7);
    header("Location: ./landing.php");
} else if (!$_COOKIE["entered"]) {
    header("Location: ./landing.php");
}
