<?php

require 'includes/database.php';

$proposition = '?';
//makes sure the URL is properly formatted in case there are other get elements in the URL prior to adding the error msg
if (isset($_POST['forward']) && strpos($_POST['forward'], '?') !== false) {
    $proposition = '&';
}

if (isset($_POST['loginname']) && isset($_POST['loginpw'])) {

    $username = $_POST['loginname'];
    $password = $_POST['loginpw'];
    $pdo = connect();

    $fetch = $pdo->query("SELECT * from swap_users WHERE username LIKE '$username'")->fetch();

    //verify login data
    if (!$fetch || !password_verify($password, $fetch['password'])) { //login failed
        if (isset($_POST['forward'])) {
            header('Location: ' . $_POST['forward'] . $proposition . 'error=9');
            die();
        } else {
            header('Location: index.php?error=9');
            die();
        }
    } else { //login successful
        session_start();
        $_SESSION['last_active'] = time();
        $_SESSION['logged'] = true;
        $_SESSION['user_id'] = $fetch['id'];
        $_SESSION['username'] = $fetch['username'];
        $_SESSION['surname'] = $fetch['surname'];
        $_SESSION['givenname'] = $fetch['givenname'];
        $_SESSION['email'] = $fetch['email'];
        $_SESSION['dob'] = $fetch['dob'];

        if (isset($_POST['forward'])) {
            header('Location: ' . $_POST['forward']);
            die();
        } else {
            header('Location: index.php');
            die();
        }
    }
} else { //username or pw not set
    if (isset($_POST['forward'])) {
        header('Location: ' . $_POST['forward'] . $proposition . 'error=9');
        die();
    } else {
        header('Location: index.php?error=9');
        die();
    }
}

