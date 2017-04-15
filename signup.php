<?php

require 'includes/userinputs.php';
require 'includes/print_hmtl.php';
require 'includes/database.php';
include 'includes/error_builder.php';

$pdo = connect();

$added = false;
$fetch = NULL;
$error = array();

if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $surname = $_POST['surname'];
    $givenname = $_POST['givenname'];
    $password = $_REQUEST['password'];
    $password2 = $_REQUEST['password2'];

    $added = add_user($pdo, $username, $email, $password, $password2, $surname, $givenname);
    if ($added) $fetch = get_user_info($pdo, $username);
}

if (isset($_GET["error"])) {
    error_highlight($error, $_GET["error"]);
}
print_before();
?>
    <div class="padding"></div>
    <p>Please enter your information to create a new account.</p>
    <br>
    <form action="signup.php" method="post" class="form">
        <p class="formline">
            <label for="username" class="signup">Username:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="username" id="username" class="signup" required minlength="6" maxlength="16"
                   pattern="[0-9a-zA-Z]{6,16}"<?php if (isset($_GET["error"])) echo $error[1]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 1); ?>
        </p><br>

        <p class="formline">
            <label for="email" class="signup">Email:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="email" name="email" id="email" class="signup" required<?php if (isset($_GET["error"])) echo $error[2]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 2); ?>
        </p><br>

        <p class="formline">
            <label for="password" class="signup">
                <span class="tooltip">Password<span class="tooltiptext">Choose a password with 6 to 16 characters
                        including upper case letters, lower case letters and numbers (at least one of each).</span>
                </span>:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="password" id="password" class="signup" required minlength="6" maxlength="16"
                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,16}$"<?php if (isset($_GET["error"])) echo $error[3]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 3); ?>
        </p><br>

        <p class="formline">
            <label for="password2" class="signup">Repeat Password:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="password2" id="password2" class="signup" required
                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,16}$"<?php if (isset($_GET["error"])) echo $error[6]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 6); ?>
        </p><br>

        <p class="formline">
            <label for="surname" class="signup">Surname:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="surname" id="surname" class="signup" required
                   pattern="^[a-zA-Z'-]{1,64}$"<?php if (isset($_GET["error"])) echo $error[4]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 4); ?>
        </p><br>

        <p class="formline">
            <label for="givenname" class="signup">Given name:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="givenname" id="givenname" class="signup" required
                   pattern="^[a-zA-Z'-]{1,64}$"<?php if (isset($_GET["error"])) echo $error[5]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 5); ?>
        </p><br>

        <span class="submit">
            <br>
            <input type="submit" value="Send">
        </span>
    </form>
    <?php if (isset($added)) {
        if ($added) {
            echo "User " . $fetch["username"] . " (" . $fetch["givenname"] . " " . $fetch["surname"] . ") was added.";
        }
    } ?>
    <div class="padding"></div>
<?php print_after();
