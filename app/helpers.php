<?php


function parsePhone($phone) {
    $phone = preg_replace('~[^0-9]~', '', $phone);

    if (substr($phone, 0, 3) == '972') {
        $phone = substr($phone, 3);
    } else if (substr($phone, 0, 1) == 0) {
        $phone = substr($phone, 1);
    }

    return $phone;
}

?>