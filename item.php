<?php

require 'print_hmtl.php';
/** @var $msg array */
require 'includes/database.php';

$pdo = connect();

print_before("item");

//this marks the according item as selected by the logged in user or deselects it
if (isset($_GET['id']) && $_GET['id'] && isset($_POST['select']) && isset($_SESSION['logged'])) {
    if ($_POST['select'] == 'Select') {
        $sql = 'UPDATE items SET selected = ? WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $selected = $stmt->execute([$_SESSION['user_id'], $_GET['id']]);
        if ($selected) echo '<p>You have successfully selected this item.';
    } else if ($_POST['select'] == 'Deselect') {
        $sql = 'UPDATE items SET selected = ? WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $deselected = $stmt->execute([0, $_GET['id']]);
        if ($deselected) echo '<p>You have successfully deselected this item.';
    }

}

$creator = "Please log in to see who is offering this game.";
$select = "Please log in to add this item to your selection.";

//only if there is an id given and no error has occurred, the item will be displayed
if (isset($_GET['id']) && (!isset($_GET['error']) || $_GET['error'] === '' || $_GET['error'] == 9)) {

    //for logged in users the uploader's username will be displayed
    if (isset($_SESSION['logged'])) {
        $sql = "SELECT username, creator, selected, i.id FROM swap_users u INNER JOIN items i ON u.id = i.creator WHERE i.id = ?";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([$_GET['id']]);
        if ($success) {
            $fetch = $stmt->fetch();
            $creator = $fetch['username'];
            get_select_row($select, $fetch);
        }
    }

    //gets the item details from the db
    $sql = "SELECT * FROM items WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($_GET['id']));

    //either user is not logged or he has the item selected (equivalent to if he is logged in, he has to have it selected)
    $selected_by_current_user = !isset($_SESSION['logged']) || $fetch['selected'] == $_SESSION['user_id'];

    //if the db access was successful and the item is not selected or selected by the current user
    //if he is logged in the page will be displayed
    if (($fetch = $stmt->fetch()) && ($fetch['selected'] == 0 || $selected_by_current_user)) {
        echo '<h4>' . $fetch['title'] . '</h4>
<img class="item_page" src="images/' . $fetch['image'] . '" alt="' . $fetch['title'] . '"/>
<br>
<table class="item_page">
    <tr>
        <td>Title:&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>' . $fetch['title'] . '</td>
    </tr>
    <tr>
        <td>Upload date:&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>' . substr($fetch['creation_date'], 0, 10) . '</td>
    </tr>
    <tr>
        <td>Platform:&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>' . get_platform_name($fetch['platform']) . '</td>
    </tr>
    <tr>
        <td>Pegi:&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>' . $fetch['pegi'] . '</td>
    </tr>
    <tr>
        <td>Owner:&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>' . $creator . '</td>
    </tr>
    <tr>
        <td>Description:&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>' . $fetch['description'] . '</td>
    </tr>
    <tr>
        <td>Selection:&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>' . $select . '</td>
    </tr>
</table>';
    } else { //otherwise the user is redirected to an error page
        header("Location: item.php?error=17");
        die();
    }
} else if (isset($_GET['error']) && $_GET['error'] == 17) { //this is the error page
    echo $msg[17];
} else { //always the same error page to hide information (is the item selected by someone else or doesnt it exist?) from unauthorized users
    header("Location: item.php?error=17");
    die();
}

print_after();