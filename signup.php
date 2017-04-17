<?php

require 'print_hmtl.php'; /** @var $error array */
require 'includes/database.php';

$pdo = connect();

$added = false;
$fetch = NULL;

$date = date("Y-m-d");

if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $surname = $_POST['surname'];
    $givenname = $_POST['givenname'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $dob = $_POST['dob'];

    $added = add_user($pdo, $username, $email, $password, $password2, $surname, $givenname, $dob);
    if ($added) $fetch = get_info_by_username($pdo, $username);
}


print_before("signup");
?>
    <p>Please enter your information to create a new account.</p>
    <br>
    <form action="signup.php" method="post" class="form">
        <p class="formline">
            <label for="username" class="formelement">Username:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="username" id="username" class="formelement" required minlength="6" maxlength="16"
                   pattern="[0-9a-zA-Z]{6,16}"<?php if (isset($_GET["error"])) echo $error[1]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 1); ?>
        </p><br>

        <p class="formline">
            <label for="email" class="formelement">Email:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="email" name="email" id="email" class="formelement"
                   required<?php if (isset($_GET["error"])) echo $error[2]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 2); ?>
        </p><br>

        <p class="formline">
            <label for="password" class="formelement">
                <span class="tooltip">Password<span class="tooltiptext">Choose a password with 6 to 16 characters
                        including upper case letters, lower case letters and numbers (at least one of each).</span>
                </span>:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="password" id="password" class="formelement" required minlength="6" maxlength="16"
                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,16}$"<?php if (isset($_GET["error"])) echo $error[3]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 3); ?>
        </p><br>

        <p class="formline">
            <label for="password2" class="formelement">Repeat Password:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="password2" id="password2" class="formelement" required
                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,16}$"<?php if (isset($_GET["error"])) echo $error[6]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 6); ?>
        </p><br>

        <p class="formline">
            <label for="surname" class="formelement">Surname:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="surname" id="surname" class="formelement" required
                   pattern="^[a-zA-Z'-]{1,64}$"<?php if (isset($_GET["error"])) echo $error[4]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 4); ?>
        </p><br>

        <p class="formline">
            <label for="givenname" class="formelement">Given name:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="givenname" id="givenname" class="formelement" required
                   pattern="^[a-zA-Z'-]{1,64}$"<?php if (isset($_GET["error"])) echo $error[5]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 5); ?>
        </p><br>

        <p class="formline">
            <label for="dob" class="formelement">Date of birth:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="date" name="dob" id="dob" class="formelement" required min="1900-01-01" max=<?php echo '"' . $date . '"';
            if (isset($_GET["error"])) echo $error[8]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 8); ?>
        </p><br>

        <p class="formline">
            <input type="submit" value="Send">
        </p>
    </form>
<?php if (isset($added)) {
    if ($added) {
        echo "User " . $fetch["username"] . " (" . $fetch["givenname"] . " " . $fetch["surname"] . ") was added. You may now log in.";
    }
}

print_after();
