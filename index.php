<?php

require 'includes/database.php';
require 'print_hmtl.php';

$pdo = connect();

print_before("index");

?>
<h2>Welcome to GAMESWAP!</h2><br><br>
<p>On this website you can trade your old games for what could be your next favourite game.
    All you need to do is sign up or log in and you are ready to go.</p>
<h4>Happy swapping!</h4>

<?php print_after();?>
