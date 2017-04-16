<?php

require 'includes/print_hmtl.php';
require 'includes/database.php';

$pdo = connect();

$added = false;
$fetch = NULL;


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


print_before("add_item");
?>
    <div class="padding"></div>
    <p>Please enter your information to create a new account.</p>
    <br>
    <form action="add_item.php" method="post" id="form" class="form" enctype="multipart/form-data">
        <p class="formline">
            <label for="title" class="formelement">Game title:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="title" id="title" class="formelement" required
                   maxlength="60"<?php if (isset($_GET["error"])) echo $error[1]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 1); ?>
        </p><br>

        <p class="formline">
            <label for="plattform" class="formelement">Plattform:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <?php echo print_pick_options(); ?>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 2); ?>
        </p>
        <br>

        <p class="formline">
            <label for="title" class="formelement">Description:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <textarea class="formelement" form="form" cols="30" rows="3" maxlength="300"
                      placeholder="Please briefly describe the game." required<?php
            if (isset($_GET["error"])) echo $error[1]; ?>></textarea>
        </p><br>

        <p class="formline">
            <label for="pegi" class="formelement">
                <span class="tooltip">Pegi<span class="tooltiptext">Please specify the age restriction for the game you wish to swap.
                        The age categories are from 3, 7, 12, 16 and 18 years.</span>
                </span>:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="number" name="pegi" id="pegi" class="formelement" min="3" max="18" pattern="^3|7|12|16|18$"
                   required<?php if (isset($_GET["error"])) echo $error[6]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 6); ?>
        </p><br>

        <p class="formline">
            <label for="image" class="formelement">Image:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="file" name="image" id="image" class="formelement" accept="image/png,image/jpeg" size="393216"
                   required<?php if (isset($_GET["error"])) echo $error[4]; ?>>
            <?php if (isset($_GET["error"])) print_error_msg($_GET["error"], 4); ?>
        </p><br>

        <p class="formline">
            <input type="submit" value="Send">
        </p>
    </form>
<?php if (isset($added)) {
    if ($added) {
        echo "User " . $fetch["username"] . " (" . $fetch["givenname"] . " " . $fetch["surname"] . ") was added. You may now log in.";
    }
} ?>
    <div class="padding"></div>
<?php print_after();
