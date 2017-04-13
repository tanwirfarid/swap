<?php
function validate_signup($username, $email, $password, $surname, $givenname)
{
    if (preg_match("/[0-9a-zA-Z]{6,16}/", $username)) return $username;
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) return $email;
    if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,16}$/", $password)) return $password;
    if (preg_match("/^[a-zA-Z'-]+$/", $surname)) return $surname;
    if (preg_match("/^[a-zA-Z'-]+$/", $givenname)) return $givenname;
    return "";
}

function add_user(PDO $pdo, $username, $email, $password, $surname, $givenname)
{
    $sql = "SELECT username FROM swap_users WHERE username= :username";
    $check = $pdo->prepare($sql);

    $user_exists = true;

    try {
        $check->execute(array(':username' => $username));
        $fetch = $check->fetch(PDO::FETCH_ASSOC);
        $user_exists = ($fetch["username"] == $username);
    } catch (PDOException $exception) {
        echo $exception->errorInfo;
    } finally {
    }

    if (!$user_exists) {
        $stmt = $pdo->prepare('INSERT INTO swap_users (username, password, surname, givenname) VALUES (?,?,?,?)');
        $added = $stmt->execute([$username, $password, $surname, $givenname]);
    } else {
        $added = false;
    }
    return $added;
}

function get_user_info(PDO $pdo, $username)
{
    $sql = "SELECT * FROM swap_users WHERE username= :username";
    $exec = $pdo->prepare($sql);
    $exec->execute(array(':username' => $username));
    $fetch = $exec->fetch(PDO::FETCH_ASSOC);
    return $fetch;
}