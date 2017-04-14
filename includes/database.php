<?php
const HOST = '127.0.0.1';
const DB = 'f030563g';
const USER = 'f030563g';
const PASSWORD = 'f030563g';
const CHARSET = 'utf8';
const DSN = "mysql:host=" . HOST . ";dbname=" . DB . ";charset=" . CHARSET;
const OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

class DatabaseConnection
{
    static function connect()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["PDO"])) {
            $_SESSION["PDO"] = new PDO(DSN, USER, PASSWORD, OPTIONS);
        }
    }
}