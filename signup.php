<?php

require 'includes/userinputs.php';
require 'includes/print_hmtl.php';
include 'includes/has_entered_check.php';
include 'includes/error_builder.php';

EnterCheck::has_entered("");

$added = false;
$fetch = NULL;

if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $surname = $_POST['surname'];
    $givenname = $_POST['givenname'];
    $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);

    $added = add_user($username, $email, $password, $surname, $givenname);
    if ($added) $fetch = get_user_info($username);
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php print_head(); ?>
</head>
<body>
<header>
    <?php print_header(); ?>
</header>
<nav>
    <?php print_nav(); ?>
</nav>
<main>
    <p>Please enter your information to create a new account.</p>
    <br>
    <form action="signup.php" method="post" class="form">
        <p class="formline">
            <label for="username" class="signup">Username:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="username" id="username" class="signup" required minlength="6" maxlength="16"
                   pattern="[0-9a-zA-Z]{6,16}"<?php if(isset($_GET["error"])) get_input_error($_GET["error"], 1);?>>
            <?php if (isset($_GET["error"])) get_error_msg($_GET["error"], 1);?>
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

        <input type="submit" value="Send">
    </form>

    <?php if ($added) {
        echo "User " . $fetch["username"] . " (" . $fetch["givenname"] . " " . $fetch["surname"] . ") was added.";
    } else if ($_REQUEST) {
        echo "Username not available.";
    } ?>
</main>
<footer><?php print_footer();?></footer>
</body>
</html>
