<?php
include_once 'login-config.php';   // As functions.php is not included
$dsn = "mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=" . CHARSET;
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, USER, PASSWORD, $opt);