<?php

const FOCUS = " style=\"outline: red solid\" autofocus";

function get_input_error($error, $field)
{
    switch ($field) {
        case 1:
            if ($error == 1 || $error == 6) echo FOCUS;
            break;
        case 2:
            if ($error == 2 || $error == 7) echo FOCUS;
            break;
        case 3:
            if ($error == 3) echo FOCUS;
            break;
        case 4:
            if ($error == 4) echo FOCUS;
            break;
        case 5:
            if ($error == 5) echo FOCUS;
    }
}

function get_error_msg($error, $field)
{
    switch ($field) {
        case 1:
            if ($error == 1) echo "<br><br>Please choose a username consisting of 6 to 16 letters.";
            break;
    }
}