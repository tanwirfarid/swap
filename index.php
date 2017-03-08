<?php
if ($_REQUEST) {
    $username = $_REQUEST['username'];
    $surname = $_REQUEST['surname'];
    $givenname = $_REQUEST['givenname'];

    $host = '127.0.0.1';
    $db   = 'f030563g';
    $user = 'f030563g';
    $pass = 'f030563g';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);

    $stmt = $pdo->prepare('INSERT INTO swap_users (username, surname, givenname) VALUES (?,?,?)');
    $added = $stmt->execute([$username, $surname, $givenname]);

    $sql = "SELECT * FROM swap_users WHERE username= :name ";
    $exec = $pdo->prepare($sql);
    $exec->execute(array(':name'=>'affe'));
    $fetch = $exec->fetch(PDO::FETCH_ASSOC);

    if($added) echo "User " . $fetch["username"] . " (" . $fetch["givenname"] . " " . $fetch["surname"] . ") was added.";

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
    <form action="index.php" method="post">
        <label for="username">Username:&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type="text" name="username" id="username">
        <p></p>

        <label for="surname">Surname:&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type="text" name="surname" id="surname">
        <p></p>

        <label for="givenname">Given name:&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type="text" name="givenname" id="givenname">
        <p></p>

        <input type="submit">
    </form>
</main>
<footer></footer>
</body>
</html>
