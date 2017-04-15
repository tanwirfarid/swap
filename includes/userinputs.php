<?php

function validate_signup($username, $email, $password, $password2, $surname, $givenname)
{
    if (!preg_match("/^[0-9a-zA-Z]{6,16}$/", $username)) return 1;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return 2;
    if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*0-9)[a-zA-Z0-9]{6,16}$/", $password)) return 3;
    if (!preg_match("/^[a-zA-Z'-]+$/", $surname)) return 4;
    if (!preg_match("/^[a-zA-Z'-]+$/", $givenname)) return 5;
    if (!($password == $password2)) return 6;
    return 0;
}

function add_user(PDO $pdo, $username, $email, $password, $password2, $surname, $givenname)
{
    $valid = validate_signup($username, $email, $password, $password2, $surname, $givenname);

    switch ($valid) {
        case 0:
            break;
        case 1:
            header("Location: ./signup.php?error=1");
            die();
            break;
        case 2:
            header("Location: ./signup.php?error=2");
            die();
            break;
        case 3:
            header("Location: ./signup.php?error=3");
            die();
            break;
        case 4:
            header("Location: ./signup.php?error=4");
            die();
            break;
        case 5:
            header("Location: ./signup.php?error=5");
            die();
            break;
        case 6:
            header("Location: ./signup.php?error=8");
            die();
            break;
    }

    $sql = "SELECT username, email FROM swap_users";
    $check = $pdo->prepare($sql);

    $check->execute();
    $fetch = $check->fetchall(PDO::FETCH_ASSOC);
    $exists = entry_exists($fetch, $username, $email);

    $added = false;

    if (!$exists) {
        $stmt = $pdo->prepare('INSERT INTO swap_users (username, email, password, surname, givenname) VALUES (?,?,?,?,?)');
        $added = $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $surname, $givenname]);
    } else if ($exists == 1) {
        header("Location: ./signup.php?error=6");
    } else if ($exists == 2) {
        header("Location: ./signup.php?error=7");
    }
    return $added;
}

function entry_exists($fetch, $username, $email)
{
    foreach ($fetch as $row) {
        if ($row["username"] == $username) return 1;
        if ($row["email"] == $email) return 2;
    }
    return 0;
}

function get_user_info(PDO $pdo, $username)
{
    $sql = "SELECT * FROM swap_users WHERE username= :username";
    $exec = $pdo->prepare($sql);
    $exec->execute(array(':username' => $username));
    return $exec->fetch(PDO::FETCH_ASSOC);
}