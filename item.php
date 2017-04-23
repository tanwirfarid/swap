<?php

require 'print_hmtl.php';
/** @var $msg array */
require 'includes/database.php';

$pdo = connect();

print_before("item");

$creator = "Please log in to see who is offering this game.";

if (isset($_SESSION['logged'])) {
    $sql = "SELECT username FROM swap_users u INNER JOIN items i ON u.id = i.creator WHERE i.creator = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
    $fetch = $stmt->fetch();
    $creator = $fetch['username'];
}

if (isset($_GET['id'])) {

    $sql = "SELECT * FROM items WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($_GET['id']));

    //either user is not logged
    $selected_by_current_user = !isset($_SESSION['logged']) || ($fetch['selected'] == $_SESSION['user_id']);

    if (($fetch = $stmt->fetch()) && ($fetch['selected'] == 0 || $selected_by_current_user)) {
        echo '<h4>' . $fetch['title'] . '</h4>
<img class="item_page" src="images/' . $fetch['image'] . '" alt="' . $fetch['title'] . '"/>
<br>
<table>
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
</table>';
    } else {
        header("Location: item.php?error=17");
        die();
    }
} else if (isset($_GET['error']) && $_GET['error'] == 17) {
    echo $msg[17];
}

print_after();