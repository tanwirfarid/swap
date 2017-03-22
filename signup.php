<?php
require 'includes/userinputs.php';

if ($_REQUEST) {
    $username = $_REQUEST['username'];
    $surname = $_REQUEST['surname'];
    $givenname = $_REQUEST['givenname'];
    $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);

    $host = '127.0.0.1';
    $db = 'f030563g';
    $user = 'f030563g';
    $pass = 'f030563g';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);

    $added = add_user($pdo, $username, $password, $surname, $givenname);

    if ($added) {
        $fetch = get_user_info($pdo, $username);
        echo "User " . $fetch["username"] . " (" . $fetch["givenname"] . " " . $fetch["surname"] . ") was added.";
    } else {
        echo "Username not available.";
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>SWAP</title>
</head>
<body>
<header>
    <h1>SWAP</h1>
</header>
<main>
    <form action="signup.php" method="post" class="signup">
        <p class="signup">
            <label for="username">Username:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="username" id="username">
        </p><br/>

        <p class="signup">
            <label for="password">Password:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="password" id="password">
        </p><br/>

        <p class="signup">
            <label for="surname">Surname:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="surname" id="surname">
        </p><br/>

        <p class="signup">
            <label for="givenname">Given name:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="givenname" id="givenname">
        </p><br/>

        <input type="submit">
    </form>
</main>
<footer></footer>
</body>
</html>
