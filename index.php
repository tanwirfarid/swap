<?php

require 'includes/database.php';
require 'print_hmtl.php';
/** @var $msg array */

$pdo = connect();

print_before("index");

?>
    <h2>Welcome to GAMESWAP!</h2><br><br>
    <p class="home">On this website you can trade your old games for what could be your next favourite game.
        All you need to do is sign up or log in and you are ready to go.</p>
    <br>
    <p class="home">Just create an account on our Sign Up page or if you already have an account, log in using the mask
        on
        the top right
        corner of the page. And let the fun begin. You are not sure whether this is the right website for you? Click the
        Browse
        button on the left and see for yourself.</p>
    <h4>Happy swapping!</h4>

<?php

if (isset($_GET['error'])) {
    if ($_GET['error'] == 16) echo $msg[16];
    elseif ($_GET['error'] == 18) echo $msg[18];
}

print_after();
