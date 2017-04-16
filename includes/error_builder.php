<?php

const FOCUS = " style=\"outline: red solid\" autofocus";

function get_highlight($error, $field)
{
    $result = "";
    switch ($field) {
        case 1:
            if ($error == 1 || $error == 6) $result = FOCUS;
            break;
        case 2:
            if ($error == 2 || $error == 7) $result = FOCUS;
            break;
        case 3:
            if ($error == 3) $result = FOCUS;
            break;
        case 4:
            if ($error == 4) $result = FOCUS;
            break;
        case 5:
            if ($error == 5) $result = FOCUS;
            break;
        case 6:
            if ($error == 8) $result = FOCUS;
            break;
        case 7:
            if ($error == 9) $result = FOCUS;
            break;
        case 8:
            if ($error == 10) $result = FOCUS;
    }
    return $result;
}

function error_highlight(&$error, $errorcode)
{
    for ($i = 1; $i <= 8; $i++) {
        $error[$i] = get_highlight($errorcode, $i);
    }
}

function print_error_msg($error, $field)
{
    switch ($field) {
        case 1:
            if ($error == 1) echo "<br><br>Please choose a username consisting of 6 to 16 letters or numbers.";
            if ($error == 6) echo "<br><br>Your desired username is already taken. Please choose another one.";
            break;
        case 2:
            if ($error == 2) echo "<br><br>Please enter a properly formattet email address.";
            if ($error == 7) echo "<br><br>The entered email address is already in use.";
            break;
        case 3:
            if ($error == 3) echo "<br><br>Please chose a password according to our regulations.";
            break;
        case 4:
            if ($error == 4) echo "<br><br>Please enter a valid name.";
            break;
        case 5:
            if ($error == 5) echo "<br><br>Please enter a valid name.";
            break;
        case 6:
            if ($error == 8) echo "<br><br>Passwords do not match.";
            break;
        case 7:
            if ($error == 9) echo "<p>Invalid combination of username and password.</p><br>";
            break;
        case 8:
            if ($error == 10) echo "<br><br>Please enter your birthday (which is in the past..).";
    }
}