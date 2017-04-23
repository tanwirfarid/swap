<?php

function validate_signup($username, $email, $password, $password2, $surname, $givenname, $dob)
{
    //set up date strings in actual DateTime objects
    $format = "Y-m-d";
    $date = DateTime::createFromFormat($format, $dob);
    $today = DateTime::createFromFormat($format, date($format, time()));
    $past = DateTime::createFromFormat($format, "1900-01-01");

    //validation of entries via regex/filter/comparison
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

    //checks if any validation error has occured and sends the according error code
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


    //retrieve all users and email addresses from the db to see if the user's desired name/email address is taken
    $sql = "SELECT username, email FROM swap_users";
    $check = $pdo->query($sql);
    $fetch = $check->fetchall();
    $exists = user_entry_exits($fetch, $username, $email);

    $added = false;

    if (!$exists) { //insert user entries into db if everything is valid and the name/email address is available
        $stmt = $pdo->prepare('INSERT INTO swap_users (username, email, password, surname, givenname, dob) VALUES (?,?,?,?,?,?)');
        $added = $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $surname, $givenname, $dob]);
    } else if ($exists == 1) {
        header("Location: ./signup.php?error=6");
        die();
    } else if ($exists == 2) {
        header("Location: ./signup.php?error=7");
        die();
    }
    return $added;
}

//checks for existing entries
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

function validate_new_item($title, $platform, $pegi, $image, $description)
{
    $platforms = array("ps4", "ps3", "psv", "pc", "xbox1", "xbox360", "switch", "wiiu", "3ds");

    //validates inputs when adding a new file
    if (strlen($title) > 60) return 11;
    if (!in_array($platform, $platforms))
        return 12;
    if ($pegi > 18 || $pegi < 0)
        return 13;
    if ($image['size'] > 5000000
        || !in_array($image['type'], array("image/jpeg", "image/png"))
    )
        return 14;
    if (strlen($description) > 300) return 15;
    return 0;
}

function add_item(PDO $pdo, $title, $platform, $pegi, $image, $description)
{
    $valid = validate_new_item($title, $platform, $pegi, $image, $description);

    switch ($valid) {
        case 0:
            break;
        case 11:
            header("Location: ./add_item.php?error=11");
            die();
            break;
        case 12:
            header("Location: ./add_item.php?error=12");
            die();
            break;
        case 13:
            header("Location: ./add_item.php?error=13");
            die();
            break;
        case 14:
            header("Location: ./add_item.php?error=14");
            die();
            break;
        case 15:
            header("Location: ./add_item.php?error=15");
            die();
            break;
    }


    $filename = time();
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

    //simple hash for the filename to make sure it's not taken
    while (file_exists("images/$filename" . $extension)) {
        $filename = (int)$filename * rand(0.1, 0.9);
    }

    $file_saved = move_uploaded_file($image['tmp_name'], "images/$filename.$extension");

    if (!$file_saved) {
        header("Location: ./add_item.php?error=14");
        die();
    }

    $creation_date = date("Y-m-d H:i:s", time());

    $added = false;

    if ($file_saved) {
        $sql = 'INSERT INTO items (title, description, creation_date, creator, platform, pegi, image, selected) VALUES (?,?,?,?,?,?,?,?)';

        $stmt = $pdo->prepare($sql);
        $added = $stmt->execute(
            [filter_var($title), filter_var($description), $creation_date, $_SESSION['user_id'], $platform, $pegi, "$filename.$extension", 0]);
    }

    return $added;
}

function build_sql_with_filter(&$sql, &$args)
{
    $platforms = array("ps4", "ps3", "psv", "pc", "xbox1", "xbox360", "switch", "wiiu", "3ds");
    $order = '';

    if ((isset($_GET['date']) && $_GET['date'])
        || (isset($_GET['platform']) && $_GET['platform'] !== '')
        || (isset($_GET['pegi'])) && $_GET['pegi'] !== ''
        || (isset($_GET['search'])) && $_GET['search'] !== '') {

        $sql .= " WHERE ";

        if (isset($_GET['date']) && $_GET['date'] !== "") {
            $sql .= "creation_date > :date";
            $args[':date'] = $_GET['date'];
            if ((isset($_GET['platform']) && $_GET['platform'] !== '')
                || (isset($_GET['pegi']) && $_GET['pegi']) !== ''
                || (isset($_GET['search']) && $_GET['search']) !== '') $sql .= " AND ";
        }

        if (isset($_GET['platform']) && in_array($_GET['platform'], $platforms)) {
            $sql .= "platform = :platform";
            $args[':platform'] = $_GET['platform'];
            if (isset($_GET['pegi']) && $_GET['pegi'] !== ''
                || (isset($_GET['search']) && $_GET['search']) !== '') $sql .= " AND ";
        }

        if (isset($_GET['pegi']) && $_GET['pegi'] !== '' && $_GET['pegi'] <= 18 && $_GET['pegi'] >= 0) {
            $sql .= "pegi <= :pegi";
            $args[':pegi'] = $_GET['pegi'];
            if ((isset($_GET['search']) && $_GET['search']) !== '') $sql .= " AND ";
        }

        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $sql .= "title LIKE :title";
            $args[':title'] = '%' . $_GET['search'] . '%';
        }
    }

    if (isset($_GET['order'])) {
        if ($_GET['order'] == 'asc') $order = " ORDER BY creation_date ASC";
        if ($_GET['order'] == 'desc') $order = " ORDER BY creation_date DESC";
    }
    $sql .= $order;
}