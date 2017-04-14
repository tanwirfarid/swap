<?php

include 'includes/has_entered_check.php';
include 'includes/print_hmtl.php';

if(isset($_GET["enter"])) {
    EnterCheck::has_entered($_GET["enter"]);
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php print_head();?>
</head>
<body>
<header>
    <?php print_header();?>
</header>
<nav>
    <?php print_nav();?>
</nav>
<main>

</main>
<footer>
    <?php print_footer();?>
</footer>
</body>
</html>
