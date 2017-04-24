<?php
const HOST = '127.0.0.1';
const DB = 'f030563g';
const USER = 'f030563g';
const PASSWORD = 'f030563g';
const CHARSET = 'utf8';
define('DSN', 'mysql:host=' . HOST . ';dbname=' . DB . ';charset=' . CHARSET);
define('OPTIONS', serialize(array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false)));

//simply sets up the db connection, that's all
function connect()
{
    return new PDO(DSN, USER, PASSWORD, unserialize(OPTIONS));
}