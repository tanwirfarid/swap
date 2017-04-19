<?php

require 'print_hmtl.php';
require 'includes/database.php';

$pdo = connect();

print_before("item");

if (isset($_GET['id'])) {

    $sql = "SELECT * FROM items WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($_GET['id']));

    if ($fetch = $stmt->fetch()) {
        echo '<h4>' . $fetch['title'] . '</h4>
<img class="item" src="images/' . $fetch['image'] . '"/>
<div class="specs">
    hallo
</div> ';
    }

}

print_after();