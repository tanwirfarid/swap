<?php

const FOCUS = " style='outline: red solid' autofocus";

function get_error_msg($error, &$msg, &$highlight)
{
    $highlight = ["dev", "", "", "", "", "", "", "", "", "", "", "", ""];
    $msg = ["dev", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""];
    switch ($error) {
        case 1:
            $msg[1] = "<br><br>Please choose a username consisting of 6 to 16 letters or numbers.";
            $highlight[1] = FOCUS;
            break;
        case 6:
            $msg[6] = "<br><br>Your desired username is already taken. Please choose another one.";
            $highlight[1] = FOCUS;
            break;
        case 2:
            $msg[2] = "<br><br>Please enter a properly formattet email address.";
            $highlight[2] = FOCUS;
            break;
        case 7:
            $msg[7] = "<br><br>The entered email address is already in use.";
            $highlight[2] = FOCUS;
            break;
        case 3:
            $msg[3] = "<br><br>Please chose a password according to our regulations.";
            $highlight[3] = FOCUS;
            break;
        case 4:
            $msg[4] = "<br><br>Please enter a valid name.";
            $highlight[4] = FOCUS;
            break;
        case 5:
            $msg[5] = "<br><br>Please enter a valid name.";
            $highlight[5] = FOCUS;
            break;
        case 8:
            $msg[8] = "<br><br>Passwords do not match.";
            $highlight[6] = FOCUS;
            break;
        case 9:
            $msg[9] = "<p>Invalid combination of username and password.</p><br>";
            $highlight[7] = FOCUS;
            break;
        case 10:
            $msg[10] = "<br><br>Please enter your birthday (which is in the past..).";
            $highlight[8] = FOCUS;
            break;
        case 11:
            $msg[11] = "<br><br>Please enter a title with at most 60 characters.";
            $highlight[9] = FOCUS;
            break;
        case 12:
            $msg[12] = "<br><br>Please select a valid platform from the dropdown.";
            $highlight[10] = FOCUS;
            break;
        case 13:
            $msg[13] = "<br><br>Please select a valid age class.";
            $highlight[11] = FOCUS;
            break;
        case 14:
            $msg[14] = "<br><br>Please select an image in JPEG or PNG format with a maximum file size of 5 megabytes";
            $highlight[12] = FOCUS;
            break;
        case 15:
            $msg[15] = "<br><br>Please keep your description short. (Maximum of 300 characters.";
            $highlight[13] = FOCUS;
            break;
        case 16:
            $msg[16] = "<br><br><p class='caution'>Please make sure you are logged in before you try adding an item.</p>";
            break;
        case 17:
            $msg[17] = "<p>Could not find the item. Sorry for the inconvenience.</p>";
            break;
        case 18:
            $msg[18] = "<p class='caution'>You are already logged in so you cant access the Sign Up page.</p>";
            break;
    }
}