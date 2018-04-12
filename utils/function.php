<?php
function echo_var(&$var) {
    if(isset($var)) {
        echo $var;
    }
}

function redirect($link) {
    header("Location: " . $link);
}

function redirect_msg($link, $msg) {
    header("Location: " . $link . "?" . $msg);
}

?>