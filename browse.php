<?php

require 'includes/database.php';
require 'print_hmtl.php';

$pdo = connect();

$platforms = array("ps4", "ps3", "psv", "pc", "xbox1", "xbox360", "switch", "wiiu", "3ds");

$order = $date = $platform = $pegi = "";
$sql = "SELECT id, image, selected FROM items";
$args = array();

if (isset($_GET['date']) || isset($_GET['platform']) || isset($_GET['pegi'])) {
    $sql .= " WHERE ";

    if (isset($_GET['date']) && $_GET['date'] !== "") {
        $sql .= "creation_date > :date";
        $args[':date'] = $_GET['date'];
        if (isset($_GET['platform']) || isset($_GET['pegi'])) $sql .= " AND ";
    }


    if (isset($_GET['platform']) && in_array($_GET['platform'], $platforms)) {
        $sql .= "platform = :platform";
        $args[':platform'] = $_GET['platform'];
        if (isset($_GET['pegi'])) $sql .= " AND ";
    }

    if (isset($_GET['pegi']) && $_GET['pegi'] !== "" && $_GET['pegi'] <= 18 && $_GET['pegi'] >= 0) {
        $sql .= "pegi <= :pegi";
        $args[':pegi'] = $_GET['pegi'];
    }

    //isset($_GET['order']) ||
    if (isset($_GET['order'])) {
        if ($_GET['order'] == 'asc') $order = " ORDER BY creation_date ASC";
        if ($_GET['order'] == 'desc') $order = " ORDER BY creation_date DESC";
    }
}

$stmt = $pdo->prepare($sql . $order);
$stmt->execute($args);
$fetch = $stmt->fetchAll();

var_dump($stmt);

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
