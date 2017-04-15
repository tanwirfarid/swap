<?php

include 'includes/database.php';
include 'includes/print_hmtl.php';

$pdo = connect();

print_before();

?>
<h2>Welcome to GAMESWAP!</h2><br><br>
<p>On this website you can trade your old games for what could be your next favourite game.
    All you need to do is sign up or log in and you are ready to go.</p>
<h4>Happy Swapping!</h4>

<?php print_after();?>
