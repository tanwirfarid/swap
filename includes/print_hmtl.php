<?php

function print_head()
{
    echo
    "<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family=Roboto:300,400,500,700\" type=\"text/css\">
    <link rel=\"icon\" href=\"./images/favicon.ico\" type=\"image/ico\" sizes=\"32x32\">
    <link rel=\"stylesheet\" href=\"./style.css\" type=\"text/css\">
    <title>GAMESWAP</title>";
}

function print_header()
{
    echo "<a href='./index.php' class='header'><img src=\"./images/header-logo.png\" alt=\"GAMESWAP\" class='header'>
    <h1>AMESWAP</h1></a>";
}

function print_nav()
{
    echo
    "<form>
        <input type=\"search\" class=\"navsrch\" name=\"search\" title=\"Search\">
    </form>
    <a href=\"./index.php\" class=\"navbtn\">Home</a>
    <a href=\"./signup.php\" class=\"navbtn\">Sign Up</a>";
}

function print_footer()
{
    echo "<p>&copy; Harambe 1998 - 2016</p>";
}