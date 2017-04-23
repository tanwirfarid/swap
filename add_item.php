<?php

require 'print_hmtl.php';
require 'includes/database.php';

/** @var $highlight array
 * @var $msg array
 */

$pdo = connect();

$added = false;
$fetch = NULL;


if (!isset($_SESSION["logged"])) {
    header("Location: index.php?error=16");
    die();
}

if ($_POST) {
    $title = $_POST['title'];
    $platform = $_POST['platform'];
    $pegi = $_POST['pegi'];
    $image = $_FILES['image'];
    $description = $_POST['description'];

    $added = add_item($pdo, $title, $platform, $pegi, $image, $description);
}


print_before("add_item");
?>
    <p>Please fill the form to enter the game you would like to swap with others.</p>
    <br>
    <form action="add_item.php" method="post" id="form" class="form" enctype="multipart/form-data">
        <p class="formline">
            <label for="title" class="formelement">Game title:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="title" id="title" class="formelement" required
                   maxlength="60"<?php if (isset($_GET["error"])) echo $highlight[9]; ?>>
            <?php if (isset($_GET["error"])) echo $msg[11]; ?>
        </p><br>

        <p class="formline">
            <label for="platform" class="formelement">Platform:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <?php echo print_pick_options(); ?>
            <?php if (isset($_GET["error"])) echo $msg[12]; ?>
        </p>
        <br>

        <p class="formline">
            <label for="description" class="formelement">Description:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <textarea class="formelement" name="description" form="form" cols="30" rows="3" maxlength="300"
                      placeholder="Please briefly describe the game."
                      required<?php if (isset($_GET["error"])) echo $highlight[11]; ?>>
            </textarea>
            <?php if (isset($_GET["error"])) echo $msg[13]; ?>
        </p><br>

        <p class="formline">
            <label for="pegi" class="formelement">
                <span class="tooltip">Pegi<span class="tooltiptext">Please specify the age restriction for the game you wish to swap.
                        The age categories are from 0 (unrestricted) to 18 (adults only) years.</span>
                </span>:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="number" name="pegi" id="pegi" class="formelement" min="0" max="18"
                   required<?php if (isset($_GET["error"])) echo $highlight[12]; ?>>
            <?php if (isset($_GET["error"])) echo $msg[14]; ?>
        </p><br>

        <p class="formline">
            <label for="image" class="formelement">Image:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="file" name="image" id="image" class="formelement" accept="image/png,image/jpeg" size="5000000"
                   required<?php if (isset($_GET["error"])) echo $highlight[13]; ?>>
            <?php if (isset($_GET["error"])) echo $msg[15]; ?>
        </p><br>

        <p class="formline">
            <input type="submit" value="Send">
        </p>
    </form>
<?php if (isset($added)) {
    if ($added) {
        echo "<br><br>Your game was successfully added.";
    }
} ?>
<?php print_after();
