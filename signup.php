<?php
require 'includes/userinputs.php';
include 'includes/has_entered_check.php';

$added = false;
$fetch = NULL;

if ($_REQUEST) {
    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
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

    $added = add_user($pdo, $email, $username, $password, $surname, $givenname);
    if ($added) $fetch = get_user_info($pdo, $username);

}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>SWAP</title>
</head>
<body>
<header>
    <h1>GAMESWAP</h1>
</header>
<nav>
    <form>
        <input type="search" class="navsrch" name="search" title="Search">
    </form>
    <a href="index.php" class="navbtn">Home</a>
    <a href="signup.php" class="navbtn">Sign Up</a>

</nav>
<main>
    <p>Please enter your information to create a new account.</p>
    <form action="signup.php" method="post" class="form">
        <p class="formline">
            <label for="username" class="signup">Username:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="username" id="username" class="signup" required minlength="6" maxlength="16"
                   pattern="[0-9a-zA-Z]{6,16}">
        </p><br/>

        <p class="formline">
            <label for="email" class="signup">Email:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="email" name="email" id="email" class="signup" required>
        </p><br/>

        <p class="formline">
            <label for="password" class="signup">
                <span class="tooltip">Password<span class="tooltiptext">Choose a password with 6 to 16 characters
                        including upper case letters, lower case letters and numbers (at least one of each).</span>
                </span>:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="password" id="password" class="signup" required minlength="6" maxlength="16"
                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,16}$">
        </p><br/>

        <p class="formline">
            <label for="surname" class="signup">Surname:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="surname" id="surname" class="signup" required pattern="^[a-zA-Z'-]+$">
        </p><br/>

        <p class="formline">
            <label for="givenname" class="signup">Given name:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="givenname" id="givenname" class="signup" required pattern="^[a-zA-Z'-]+$">
        </p><br/>

        <input type="submit">
    </form>

    <?php if ($added) {
        echo "User " . $fetch["username"] . " (" . $fetch["givenname"] . " " . $fetch["surname"] . ") was added.";
    } else if ($_REQUEST) {
        echo "Username not available.";
    } ?>
</main>
<footer></footer>
</body>
</html>
