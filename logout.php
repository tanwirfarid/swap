<?php

session_start();
session_unset();     // unset $_SESSION variable for the run-time
session_destroy();   // destroy session data in storage

if (isset($_GET['forward']) && $_GET['forward']) {
    header('Location: ' . $_GET['forward'] . '.php?logout=success');
    die();
} else {
    header('Location: index.php?logout=success');
    die();
}