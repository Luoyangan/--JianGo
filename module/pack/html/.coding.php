<?php
function charset($charset) {
    if (is_array($charset) || is_object($charset)) {
        $charseta = $charset;
    } else {
        $charseta = (string)$charset;
    }
    echo '<meta charset="'.$charseta.'">';
}