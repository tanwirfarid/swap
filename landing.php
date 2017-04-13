<?php
if (isset($_COOKIE["entered"])) {
    if ($_COOKIE["entered"]) {
        header("Location: ./index.php");
    }
}
if (isset($_POST["enter"])) {
    if ($_POST["enter"] == "Enter") {
        setcookie("entered", true, time() + 60 * 60 * 24 * 7);
        header("Location: ./index.php");
    } else if ($_POST["enter"] == "Leave") {
        setcookie("entered", false, time() - 1);
        header("Location: http://www.google.com/");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>SWAP</title>
</head>
<body>
<div class="landing">
    <header class="landing">
        <h1>GAMESWAP</h1>
    </header>

    <main class="landing">
        <h2>Welcome!</h2>
        <br>
        <p>On this website you will be able to trade your old games for your next favourite game.</p>
        <p><b>Happy swapping!</b></p>
        <br>

        <form action="landing.php" method="post">
            <input name="enter" value="true" title="Enter" hidden>
            <input type="submit" value="Enter" autofocus name="enter" id="enter">
        </form>
        <form action="landing.php" method="post">
            <input name="enter" value="false" title="Leave" hidden>
            <input type="submit" value="Leave" autofocus name="enter" id="leave">
        </form>
    </main>

    <footer class="landing"></footer>
</div>
</body>
</html>
