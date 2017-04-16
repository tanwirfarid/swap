<?php
require 'error_builder.php';
require 'userinputs.php';

session_start();

if (!isset($_SESSION['started'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['started'] > 1800) {
    // session started more than 30 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['started'] = time();  // update creation time
}

$error = array();

if (isset($_GET["error"])) {
    error_highlight($error, $_GET["error"]);
}

function print_before($page)
{
    global $error;

    if (isset($_SESSION['last_active']) && (time() - $_SESSION['last_active'] > 1800)) {
        // last request was more than 30 minutes ago
        header('Location: logout.php?forward=' . $page);
    }

    echo
    '<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link rel="icon" href="images/favicon.ico" type="image/ico" sizes="32x32">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>GAMESWAP</title>
</head>
<body>
<header>
    <a href="./index.php" class="header"><img src="images/header-logo.png" alt="GAMESWAP" class="header"><h1>AMESWAP</h1></a>
    <div class="dropdown">
        ';
    if (isset($_SESSION['logged']) && $_SESSION['logged']) {
        echo
        "<span>Account</span>
        <div class=\"dropdown-content\">
        <a>My items</a>
        <a>My selection</a>
        <a href='logout.php?forward=$page'>Log out</a>";
    } else {
        echo
        '<span>Login</span>
        <div class="dropdown-content">';
        if (isset($_GET["error"]) && ($_GET["error"] == 9)) print_error_msg($_GET["error"], 7);
        echo '<form action="login.php" method="post" class="form">
                <p class="formline">
                    <label for="loginname" class="formelement">Username:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="text" name="loginname" id="loginname" class="formelement" required';
        if (isset($_GET["error"])) echo $error[7];
        echo '>
                </p><br>
                <p class="formline">
                    <label for="loginpw" class="formelement">Password:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="password" name="loginpw" id="loginpw" class="formelement" required';
        if (isset($_GET["error"])) echo $error[7];
        echo '>
                </p><br>
                <input type="hidden" name="forward" value="' . $page . '">
                <input type="submit" value="Login">
            </form>
        ';
    }
    echo '</div>
    </div>
</header>

<div class="wrapper">

<aside>
    <form>
       <input type="search" class="navsrch" name="search" title="Search">
    </form>
    <a href="index.php" class="navbtn">Home</a>
    <a href="browse.php" class="navbtn">Browse</a>
    <a href="add_item.php" class="navbtn">Add Item</a>
    <a href="signup.php" class="navbtn">Sign Up</a>
</aside>

<main><br><br>';
}

function print_after()
{
    if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
        echo '<p>You were successfully logged out. Please visit again soon.</p>';
    }
    echo
    '</main></div>
<footer><p>&copy; Harambe 1998 - 2016</p></footer>';
}

function print_pick_options() {
    return '<select name="plattform" id="plattform" class="formelement"
                    required<?php if (isset($_GET["error"])) echo $error[2]; ?>>
                <option value="" disabled selected>Select..</option>
                <optgroup label="Sony">
                    <option value="ps4">PlayStation 4</option>
                    <option value="ps3">PlayStation 3</option>
                    <option value="psv">PlayStation Vita</option>
                </optgroup>
                <optgroup label="Microsoft">
                    <option value="pc">Windows</option>
                    <option value="xbox1">Xbox One</option>
                    <option value="xbox360">Xbox 360</option>
                </optgroup>
                <optgroup label="Nintendo">
                    <option value="switch">Switch</option>
                    <option value="wiiu">WiiU</option>
                    <option value="3ds">3DS</option>
                </optgroup>
            </select>';
}