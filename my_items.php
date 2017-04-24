<?php

require 'includes/database.php';
require 'print_hmtl.php';
/** @var $msg array */

$pdo = connect();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php?error=16');
    die();
}

$deletemsg = '';

//for deleting the item. this also makes sure the user can only delete items he created himself
if (isset($_POST['id']) && isset($_POST['delete'])) {
    $sql = 'DELETE FROM items WHERE id = ? AND creator = ?';
    $stmt = $pdo->prepare($sql);
    $deleted = $stmt->execute([$_POST['id'], $_SESSION['user_id']]);
    if ($deleted) $deletemsg = '<p>The item was successfully deleted.</p><br>';
}

//fetches all items from the current user and the name of the user who selected the item if it is selected
$sql = 'SELECT i.id, title, creation_date, image, username FROM items i LEFT JOIN swap_users u ON selected = u.id WHERE creator = ? ORDER BY creation_date';
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$fetch = $stmt->fetchAll();

print_before("index");
echo '<h2>My Items</h2><br>
' . $deletemsg . '
<table style="text-align: center">
    <tr>
        <th>Image</th>
        <th>Insertion Date</th>
        <th>Selected By</th>
        <th>Delete</th>
    </tr>';

foreach ($fetch as $item) {
    echo '
    <tr>
        <td><a href="item.php?id=' . $item['id'] . '"><img src="images/' . $item['image'] . '" alt="' . $item['title'] . '" class="item"</a></td>
        <td>' . substr($item['creation_date'], 0, 10) . '</td>
        <td>' . $item['username'] . '</td>
        <td><form action="my_items.php" method="post"><input type="hidden" name="id" value="' . $item['id'] . '">
        <input type="submit" name="delete" value="Delete"></form></td>
    </tr>';
}
echo '</table>';

print_after(); ?>
