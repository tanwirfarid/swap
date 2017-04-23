<?php

require 'print_hmtl.php';
require 'includes/database.php';

/** @var $highlight array
 * @var $msg array */

$pdo = connect();

if (isset($_SESSION['logged'])) {
    header('Location: index.php?error=18');
    die();
}

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
    <br>
    <p>Please enter your information to create a new account.</p>
    <br>
    <form action="signup.php" method="post" class="form">
        <p class="formline">
            <label for="username" class="formelement">Username:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="username" id="username" class="formelement" required minlength="6" maxlength="16"
                   pattern="[0-9a-zA-Z]{6,16}"<?php if (isset($_GET["error"])) echo $highlight[1]; ?>>
            <?php if (isset($_GET["error"]) && $_GET["error"] == 1) echo $msg[1];
            elseif (isset($_GET["error"]) && $_GET["error"] == 6) echo $msg[6]; ?>
        </p><br>

        <p class="formline">
            <label for="email" class="formelement">Email:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="email" name="email" id="email" class="formelement"
                   required<?php if (isset($_GET["error"])) echo $highlight[2]; ?>>
            <?php if (isset($_GET["error"]) && $_GET["error"] == 2) echo $msg[2];
            elseif (isset($_GET["error"]) && $_GET["error"] == 7) echo $msg[7]; ?>
        </p><br>

        <p class="formline">
            <label for="password" class="formelement">
                <span class="tooltip">Password<span class="tooltiptext">Choose a password with 6 to 16 characters
                        including upper case letters, lower case letters and numbers (at least one of each).</span>
                </span>:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="password" id="password" class="formelement" required minlength="6" maxlength="16"
                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,16}$"<?php if (isset($_GET["error"])) echo $highlight[3]; ?>>
            <?php if (isset($_GET["error"])) echo $msg[3]; ?>
        </p><br>

        <p class="formline">
            <label for="password2" class="formelement">Repeat Password:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" name="password2" id="password2" class="formelement" required
                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{6,16}$"<?php if (isset($_GET["error"])) echo $highlight[4]; ?>>
            <?php if (isset($_GET["error"])) echo $msg[4]; ?>
        </p><br>

        <p class="formline">
            <label for="surname" class="formelement">Surname:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="surname" id="surname" class="formelement" required
                   pattern="^[a-zA-Z'-]{1,64}$"<?php if (isset($_GET["error"])) echo $highlight[5]; ?>>
            <?php if (isset($_GET["error"])) echo $msg[5]; ?>
        </p><br>

        <p class="formline">
            <label for="givenname" class="formelement">Given name:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="givenname" id="givenname" class="formelement" required
                   pattern="^[a-zA-Z'-]{1,64}$"<?php if (isset($_GET["error"])) echo $highlight[6]; ?>>
            <?php if (isset($_GET["error"])) echo $msg[8]; ?>
        </p><br>

        <p class="formline">
            <label for="dob" class="formelement">Date of birth:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="date" name="dob" id="dob" class="formelement" required min="1900-01-01" max=<?php echo '"' . $date . '"';
            if (isset($_GET["error"])) echo $highlight[7]; ?>>
            <?php if (isset($_GET["error"])) echo $msg[9]; ?>
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
