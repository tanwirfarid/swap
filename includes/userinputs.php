<?php
function add_user($pdo, $username, $password, $surname, $givenname)
{
    $sql = "SELECT username FROM swap_users WHERE username= :username";
    $check = $pdo->prepare($sql);
    $check->execute(array(':username' => $username));
    $fetch = $check->fetch(PDO::FETCH_ASSOC);
    $user_exists = ($fetch["username"] == $username);

    if (!$user_exists) {
        $stmt = $pdo->prepare('INSERT INTO swap_users (username, password, surname, givenname) VALUES (?,?,?,?)');
        $added = $stmt->execute([$username, $password, $surname, $givenname]);
    } else {
        $added = false;
    }
    return $added;
}

function get_user_info($pdo, $username)
{
    $sql = "SELECT * FROM swap_users WHERE username= :username";
    $exec = $pdo->prepare($sql);
    $exec->execute(array(':username' => $username));
    $fetch = $exec->fetch(PDO::FETCH_ASSOC);
    return $fetch;
}