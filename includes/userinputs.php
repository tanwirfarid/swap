<?php

function validate_signup($username, $email, $password, $password2, $surname, $givenname, $dob)
{
    $format = "Y-m-d";
    $date = DateTime::createFromFormat($format, $dob);
    $today = DateTime::createFromFormat($format, date($format, time()));
    $past = DateTime::createFromFormat($format, "1900-01-01");

    if (!preg_match("/^[0-9a-zA-Z]{6,16}$/", $username)) return 1;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return 2;
    if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*0-9)[a-zA-Z0-9]{6,16}$/", $password)) return 3;
    if (!preg_match("/^[a-zA-Z'-]+$/", $surname)) return 4;
    if (!preg_match("/^[a-zA-Z'-]+$/", $givenname)) return 5;
    if (!($password == $password2)) return 6;
    if ($date > $today || $date < $past) return 8;
    return 0;
}

function add_user(PDO $pdo, $username, $email, $password, $password2, $surname, $givenname, $dob)
{
    $valid = validate_signup($username, $email, $password, $password2, $surname, $givenname, $dob);

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
        case 8:
            header("Location: ./signup.php?error=10");
            die();
            break;
    }

    $sql = "SELECT username, email FROM swap_users";
    $check = $pdo->prepare($sql);

    $check->execute();
    $fetch = $check->fetchall();
    $exists = user_entry_exits($fetch, $username, $email);

    $added = false;

    if (!$exists) {
        $stmt = $pdo->prepare('INSERT INTO swap_users (username, email, password, surname, givenname, dob) VALUES (?,?,?,?,?,?)');
        $added = $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $surname, $givenname, $dob]);
    } else if ($exists == 1) {
        header("Location: ./signup.php?error=6");
    } else if ($exists == 2) {
        header("Location: ./signup.php?error=7");
    }
    return $added;
}

function user_entry_exits($fetch, $username, $email)
{
    foreach ($fetch as $row) {
        if ($row["username"] == $username) return 1;
        if ($row["email"] == $email) return 2;
    }
    return 0;
}

function get_info_by_username(PDO $pdo, $username)
{
    $sql = "SELECT * FROM swap_users WHERE username= :username";
    $exec = $pdo->prepare($sql);
    $exec->execute(array(':username' => $username));
    return $exec->fetch();
}

function validate_new_item($title, $plattform, $pegi, $image, $description)
{
    if (!strlen($title) <= 60) return 1;
    if(!($plattform == "ps4"|| $plattform == "ps3" || $plattform == "psv" || $plattform == "pc" || $plattform == "xbox1" ||
        $plattform == "xbox360" || $plattform == "switch" || $plattform == "wiiu" || $plattform == "3ds")) return 2;
    if (!($pegi == 3 || $pegi == 7 || $pegi == 12 || $pegi == 16 || $pegi == 18)) return 3;
    if ($image) return 4;
    if (!strlen($description) <= 300) return 5;


}