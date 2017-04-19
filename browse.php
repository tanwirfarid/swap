<?php

require 'includes/database.php';
require 'print_hmtl.php';

$pdo = connect();

$sql = "SELECT id, image, selected FROM items";
$fetch = $pdo->query($sql)->fetchAll();

print_before("index");

echo '<div class="browse">';

foreach ($fetch as $item) {
    if ($item['selected'] == 0) {
        echo '<a href="item.php?id=' . $item['id'] . '"><img src="images/' . $item['image'] . '" class="item"/></a>';
    }
}

echo '</div>';
?>

<?php print_after(); ?>
