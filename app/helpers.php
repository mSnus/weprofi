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

function filterTagsExceptBr($html) {
    $html = preg_replace('~<br[^>]*>~', '__br__', $html);
    $html = preg_replace('~<[^>]*>~', '', $html);
    $html = preg_replace('~__br__~', '<br/>', $html);

    return $html;
}


function nl2p($text) {
    $html = nl2br($text);
    $html = preg_replace('~<br[^>]*>~', '</p><p>', $html);
    $html = '<p>'.$html.'</p>';

    return $html;
}

function processText($text) {
    $html = trim($text);

    if ($html) {
        $html = nl2br($text);
        $html = preg_replace('~<br[^>]*>~', '</p><p>', $html);
        $html = '<p>'.$html.'</p>';
        $html = preg_replace('~<p></p>~', '', $html);
        //    $html = preg_replace('~(https?://[^\s/]*)~', '<a href="$1" target="_blank">[ссылка]</a>', $html);
        $html = preg_replace('~([a-z0-9\.-_/+%]{10,})~', '<span class="force-breaks">$1</span>', $html);

    }

    return $html;
}

?>