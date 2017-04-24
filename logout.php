<?php

session_start();
session_unset();     // unset session variables
session_destroy();   // destroy session data in storage

//redirect to different pages depending on logout reason (timeout or manual log out)
if (isset($_GET['expired']) && $_GET['expired'] == 1) {
    header('Location: index.php?logout=auto');
    die();
} else if (isset($_GET['forward']) && $_GET['forward'] !== '' && strpos('add_item.php', $_GET['forward'])) {
    header('Location: ' . $_GET['forward'] . '&logout=success');
    die();
} else {
    header('Location: index.php?logout=success');
    die();
}