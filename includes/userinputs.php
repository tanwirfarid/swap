<?php

function validate_signup($username, $email, $password, $surname, $givenname)
{
    if (preg_match("/[0-9a-zA-Z]{6,16}/", $username)) return 1;
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) return 2;
    if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,16}$/", $password)) return 3;
    if (preg_match("/^[a-zA-Z'-]+$/", $surname)) return 4;
    if (preg_match("/^[a-zA-Z'-]+$/", $givenname)) return 5;
    return 0;
}

function add_user($username, $email, $password, $surname, $givenname)
{
    $valid = validate_signup($username, $email, $password, $surname, $givenname);

    switch ($valid) {
        case 0:
        case 1:
            header("Location: ./signup.php?error=1");
            break;
        case 2:
            header("Location: ./signup.php?error=2");
            break;
        case 3:
            header("Location: ./signup.php?error=3");
            break;
        case 4:
            header("Location: ./signup.php?error=4");
            break;
        case 5:
            header("Location: ./signup.php?error=5");
            break;
    }

    $sql = "SELECT username FROM swap_users";
    $check = $_SESSION["PDO"]->prepare($sql);

    $exists = 3;

    try {
        $check->execute(array(':username' => $username));
        $fetch = $check->fetchall(PDO::FETCH_ASSOC);
        $exists = entry_exists($fetch, $username, $email);
    } catch (PDOException $exception) {
        echo $exception->errorInfo;
    }

    $added = false;

    if (!$exists) {
        $stmt = $_SESSION["PDO"]->prepare('INSERT INTO swap_users (username, email, password, surname, givenname) VALUES (?,?,?,?,?)');
        $added = $stmt->execute([$username, $email, $password, $surname, $givenname]);
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

function get_user_info($username)
{
    $sql = "SELECT * FROM swap_users WHERE username= :username";
    $exec = $_SESSION["PDO"]->prepare($sql);
    $exec->execute(array(':username' => $username));
    return $exec->fetch(PDO::FETCH_ASSOC);
}