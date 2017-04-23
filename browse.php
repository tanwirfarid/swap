<?php

require 'includes/database.php';
require 'print_hmtl.php';

$pdo = connect();

$platforms = array("ps4", "ps3", "psv", "pc", "xbox1", "xbox360", "switch", "wiiu", "3ds");

$sql = "SELECT id, image, selected FROM items";
$args = array();

build_sql_with_filter($sql, $args);

$stmt = $pdo->prepare($sql);
$stmt->execute($args);
$fetch = $stmt->fetchAll();

print_before("browse");

echo '<div class="browse">';

foreach ($fetch as $item) {
    if ($item['selected'] == 0) {
        echo '<a href="item.php?id=' . $item['id'] . '"><img src="images/' . $item['image'] . '" class="item"/></a>';
    }
}

echo '</div>';
?>

<?php print_after(); ?>
