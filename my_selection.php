<?php

require 'includes/database.php';
require 'print_hmtl.php';
/** @var $msg array */

$pdo = connect();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php?error=16');
    die();
}

//fetches all items from the current user and the name of the user who selected the item if it is selected
$sql = 'SELECT i.id, title, image, username, email FROM items i INNER JOIN swap_users u ON selected = u.id WHERE u.id = ? ORDER BY creation_date';
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$fetch = $stmt->fetchAll();

print_before("index");
echo '<h2>My Selection</h2><br>
<table style="text-align: center">
    <tr>
        <th>Image</th>
        <th>Owner</th>
        <th>E-Mail</th>
    </tr>';

foreach ($fetch as $item) {
    echo '
    <tr>
        <td><a href="item.php?id=' . $item['id'] . '"><img src="images/' . $item['image'] . '" alt="' . $item['title'] . '" class="item"</a></td>
        <td>' . $item['username'] . '</td>
        <td>' . $item['email'] . '</td>
    </tr>';
}
echo '</table>';

print_after(); ?>
