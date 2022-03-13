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

function clear_terminal() {
    echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
}

function green_color($string) {
    return "\033[32m" . $string . "\033[0m";
}

function white_color($string) {
    return "\033[1;37m" . $string . "\033[0m";
}

define("EXIT_SUCCESS", 0);
define("BUKUTAMU", new BukuTamu());

$HEADER = <<<HEADER
Aplikasi Buku Tamu Versi 1.0
============================
HEADER;

$MENU = <<<MENU
Pilihan :
    1. Tambah Tamu
    2. Hapus Tamu
    3. Tampilkan Tamu
    4. Ubah Tamu
    5. Exit
\n
MENU;

while (TRUE) {
    clear_terminal();
    echo $HEADER . "\n";
    echo green_color(BUKUTAMU->printTamu());
    echo $MENU;
    $input = input(white_color("Masukkan pilihan: "));
    switch ($input) {
        case '1':
            clear_terminal();
            echo green_color(BUKUTAMU->printTamu());
            echo "\n\n";
            $nama = input("Masukkan nama: ");
            $alamat = input("Masukkan alamat: ");
            BUKUTAMU->addTamu($nama, $alamat);
            echo "Tamu berhasil ditambahkan\n";
            break;
        
        case '2':
            clear_terminal();
            echo green_color(BUKUTAMU->printTamu());
            echo "\n\n";
            $index = input("Masukkan index: ");
            BUKUTAMU->deleteTamu($index);
            echo "Tamu berhasil dihapus\n";
            break;

        case '3':
            clear_terminal();
            echo "Daftar Tamu\n";
            echo green_color(BUKUTAMU->printTamu());
            echo "\n";
            input("Tekan enter untuk kembali ke menu");
            break;
        
        case '4':
            clear_terminal();
            echo green_color(BUKUTAMU->printTamu());
            echo "\n\n";
            $index = input("Masukkan index: ");
            $nama = input("Masukkan nama: ");
            $alamat = input("Masukkan alamat: ");
            BUKUTAMU->modifyTamu($index, $nama, $alamat);
            echo "Tamu berhasil diubah\n";
            break;
        
        case '5':
            # exit from program
            clear_terminal();
            exit(EXIT_SUCCESS);
            break;
        
        default:
            echo "Pilihan tidak ditemukan. Silahkan pilih ulang! (press enter)\n";
            input("");
            break;
    }
}