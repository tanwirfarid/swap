<?php

require 'includes/database.php';
require 'print_hmtl.php';

$pdo = connect();

$platforms = array("ps4", "ps3", "psv", "pc", "xbox1", "xbox360", "switch", "wiiu", "3ds");

$sql = "SELECT id, image, selected, title FROM items";
$args = array();

//manipulates sql statement and args to fit the user entered filters (look at the function in 'includes/userinputs.php')
build_sql_with_filter($sql, $args);

$stmt = $pdo->prepare($sql);
$stmt->execute($args);
$fetch = $stmt->fetchAll();

print_before("browse");

echo '<div class="browse">';

//prints the images of all items wanted with links to the according item detail pages
foreach ($fetch as $item) {
    if ($item['selected'] == 0) {
        echo '<a href="item.php?id=' . $item['id'] . '"><img src="images/' . $item['image'] . '" alt="' . $item['title'] . '" class="item"/></a>';
    }
}

echo '</div>';

print_after(); ?>
