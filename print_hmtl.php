<?php
require 'includes/error_builder.php';
require 'includes/userinputs.php';

session_start();

$msg = array();
$highlight = array();

if (isset($_GET["error"])) {
    get_error_msg($_GET['error'], $msg, $highlight);
}

function print_before($page)
{
    global $highlight;
    global $msg;

    $forward = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY))) {
        $forward .= '?' . basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY));
    }

//if the session wasn't created more than 30 min since the last user interaction the session refreshes, otherwise logs out
    if (!isset($_SESSION['started'])) {
        $_SESSION['started'] = time();
    } else if (time() - $_SESSION['started'] < 1800) {
        session_regenerate_id(true);
        $_SESSION['started'] = time();
    } else {
        header("Location: logout.php?forward=$forward&expired=1");
        die();
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
    <a href="index.php" class="header"><img src="images/header-logo.png" alt="GAMESWAP" class="header"><h1>AMESWAP</h1></a>
    <div class="dropdown">
        ';
    if (isset($_SESSION['logged']) && $_SESSION['logged']) {
        echo
        "<span>Account</span>
        <div class='dropdown-content'>
        <a>My items</a>
        <a>My selection</a>
        <a href='logout.php?forward=$forward'>Log out</a>";
    } else {
        echo
        '<span>Login</span>
        <div class="dropdown-content">';
        if (isset($_GET["error"])) echo $msg[9];
        echo '<form action="login.php" method="post" class="form">
                <p class="formline">
                    <label for="loginname" class="formelement">Username:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="text" name="loginname" id="loginname" class="formelement" required';
        if (isset($_GET["error"])) echo $highlight[7];
        echo '>
                </p><br>
                <p class="formline">
                    <label for="loginpw" class="formelement">Password:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="password" name="loginpw" id="loginpw" class="formelement" required';
        if (isset($_GET["error"])) echo $highlight[7];
        echo '>
                </p><br>
                <input type="hidden" name="forward" value="' . $forward . '">
                <input type="submit" value="Login">
            </form>
        ';
    }
    echo '</div>
    </div>
</header>

<div class="wrapper">

<aside>
    <form method="get" action="browse.php">
       <input type="search" class="navsrch" name="search" title="Search">
    </form>
    <a href="index.php" class="navbtn">Home</a>
    <a href="browse.php" class="navbtn">Browse</a>
    <a href="add_item.php" class="navbtn">Add Item</a>
    <a href="signup.php" class="navbtn">Sign Up</a>
</aside>

<main>';
    if ($page == 'browse') {
        echo '<div class="filter">';
        print_filter();
        echo '</div>';
    } else {
        echo '<br>';
    }
    if (isset($_GET['error']))
        echo '<p class="caution">An error has occurred.</p><br>';
}

function print_after()
{
    if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
        echo '<br><br><p>You were successfully logged out. Please visit again soon.</p>';
    } else if (isset($_GET['logout']) && $_GET['logout'] == 'auto') {
        echo '<p class="caution">Your session expired and you were logged out for security reasons. Please log in again.</p>';
    }
    echo
    '    <br><br>
</main></div>
<footer><p>&copy; Harambe 1998 - 2016</p></footer>
</body>
</html>';
}

function print_pick_options()
{
    return '<select name="platform" id="platform" class="formelement"
                    required<?php if (isset($_GET["error"])) echo $highlight[10]; ?>>
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

function print_filter()
{
    echo '<form action="browse.php" method="get" class="filter">
    <span class="formline">
        <span class="formelement">
            <label for="date">Latest upload:</label>
            <input type="date" name="date" id="date">
        </span>
        <span class="formelement">
            <label for="platform">Platform:</label>
            ' . print_pick_options() . '
        </span>
        <span class="formelement">
            <label for="pegi">Age:</label>
            <input type="number" name="pegi" id="pegi" min="0" max="18">
        </span>
        <span class="formelement">
            <label for="order">Order:</label>
            <input type="radio" name="order" id="order" value="asc">Oldest first
            <input type="radio" name="order" id="order" value="desc">Newest first
        </span>';
    if (isset($_GET['search']) && $_GET['search'] != '') echo '<input type="hidden" name="search" value="' . $_GET['search'] . '">';
        echo '
        <span class="formelement">
            <input type="submit" value="Go">
        </span>
        <span class="formelement">
            <a class="reset" href="browse.php">Reset</a>
        </span>
    </span>
</form>';
}

function get_platform_name($platform)
{
    $result = '';

    switch ($platform) {
        case "ps4":
            $result = "Sony PlayStation 4";
            break;
        case "ps3":
            $result = "Sony PlayStation 3";
            break;
        case "psv":
            $result = "Sony PlayStation Vita";
            break;
        case "pc":
            $result = "Microsoft Windows (PC)";
            break;
        case "xbox1":
            $result = "Microsoft Xbox One";
            break;
        case "xbox360":
            $result = "Microsoft Xbox 360";
            break;
        case "switch":
            $result = "Nintendo Switch";
            break;
        case "wiiu":
            $result = "Nintendo WiiU";
            break;
        case "3ds":
            $result = "Nintendo 3DS";
            break;
    }
    return $result;
}