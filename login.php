<?php

require 'includes/database.php';

if (isset($_POST['loginname']) && isset($_POST['loginpw'])) {

    $username = $_POST['loginname'];
    $password = $_POST['loginpw'];
    $pdo = connect();

    $fetch = $pdo->query("SELECT * from swap_users WHERE username LIKE '$username'")->fetch();

    if (!$fetch || !password_verify($password, $fetch['password'])) {
        if (isset($_POST['forward'])) {
            header('Location: ' . $_POST['forward'] . '.php?error=9');
            die();
        } else {
            header('Location: index.php?error=9');
            die();
        }
    } else {
        session_start();
        $_SESSION['last_active'] = time();
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $fetch['username'];
        $_SESSION['surname'] = $fetch['surname'];
        $_SESSION['givenname'] = $fetch['givenname'];
        $_SESSION['email'] = $fetch['email'];
        $_SESSION['dob'] = $fetch['dob'];

        if (isset($_POST['forward'])) {
            header('Location: ' . $_POST['forward'] . '.php');
            die();
        } else {
            header('Location: index.php');
            die();
        }
    }
} else {
    if (isset($_POST['forward'])) {
        header('Location: ' . $_POST['forward'] . '.php?error=9');
        die();
    } else {
        header('Location: index.php?error=9');
        die();
    }
}