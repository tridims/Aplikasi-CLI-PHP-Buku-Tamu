#!/usr/bin/php
<?php

require_once "BukuTamu.php";
require_once "php-cli-colors.php";

function input($prompt = null) {
    if ($prompt) {
        echo $prompt;
    }
    $fp = fopen("php://stdin", "r");
    $input = rtrim(fgets(STDIN), "\n");
    fclose($fp);
    return $input;
}

$bukuTamu = new BukuTamu();
$bukuTamu->printTamu();

// $colors = new Colors();
// echo $colors->getColoredString("Buku Tamu", "cyan");