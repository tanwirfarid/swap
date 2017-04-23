<?php

require 'includes/database.php';
require 'print_hmtl.php'; /** @var $msg array */

$pdo = connect();

print_before("index");



?>
<h2>My Items</h2><br><br>
<p>On this website you can trade your old games for what could be your next favourite game.
    All you need to do is sign up or log in and you are ready to go.</p>
<h4>Happy swapping!</h4>

<?php

if(isset($_GET['error']) && $_GET['error'] == 16) echo $msg[16];

print_after();?>
