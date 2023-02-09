<?php


/**
 * Очищает телефон от всех символов, кроме цифр.
 * Если телефон начинается с 5 и содержит 9 цифр, он считается израильским мобильным, к нему приписываем 972
 * Если телефон начинается с 0, он считается израильским, у него убираем 0 и приписываем 972
 * В базе все телефоны хранятся как есть с кодом страны, т.е. 972534381234, 79250421234,
 * при отправке просто подставляем + в начале, если надо
 * 
 * @param mixed $phone
 * @return array|null|string
 */
function parsePhone($phone) {
    $phone = preg_replace('~[^0-9]~', '', $phone);

    if (substr($phone, 0, 1) == '5' && strlen($phone) == 9) {
        $phone = "972" . $phone;
    } else if (substr($phone, 0, 1) == 0) {
        $phone = "972".substr($phone, 1);
    }

    return $phone;
}

function beautifyPhone($phone) {
    $phone = parsePhone($phone);

	$len = strlen($phone);
    	
    if ($len > 7) {
    	
    	$phone = substr($phone, 0, $len - 7).' '.substr($phone, $len - 7,3).' '.substr($phone, $len - 4);
    	
		if ($len == 12) {
			$phone = substr($phone, 0, 3).' '.substr($phone, 3);
		} else if ($len == 12) {
			$phone = substr($phone, 0, 2).' '.substr($phone, 3);
		} 
    }
    
    $phone = '+' . $phone; 
    
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