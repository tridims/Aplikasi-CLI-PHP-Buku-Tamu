<?php

require_once "php-cli-colors.php";

class BukuTamu {
  private $dataTamu;
  private $count;

  public function __construct() {
    $this->populateData();
  }

  public function addTamu($nama, $alamat) {
    $this->dataTamu[$this->count] = [
      'nama' => $nama,
      'alamat' => $alamat
    ];

    $this->refreshData();
  }

  public function printTamu() {
    $output = "";
    $horizontalLine = "+----------------------------------------------------------------------------------+\n";
    $output .= $horizontalLine;
    $output .= sprintf("| %3s. | %-20s | %-50s |\n", 'No', 'Nama', 'Alamat');
    $output .= $horizontalLine;
    foreach ($this->dataTamu as $index => $tamu) {
      // echo $index . ' ' . $tamu['nama'] . ' - ' . $tamu['alamat'] . PHP_EOL;
      $output .= sprintf("| %3d. | %-20s | %-50s |\n", $index, $tamu['nama'], $tamu['alamat']);
    }
    $output .= $horizontalLine;
    return $output;
  }

  public function deleteTamu($index) {
    unset($this->dataTamu[$index]);
    $this->refreshData();
  }

  public function modifyTamu($index, $nama, $alamat) {
    $this->dataTamu[$index] = [
      'nama' => $nama,
      'alamat' => $alamat
    ];
    $this->refreshData();
  }

  private function exportTamuToJSON() {
    $jsonTamu = json_encode($this->dataTamu);
    file_put_contents('tamu.json', $jsonTamu);
  }

  private function loadTamuFromJSONFile() {
    # check if file exists
    if (file_exists('tamu.json')) {
      # read from file
      $jsonTamu = file_get_contents('tamu.json');
      $this->dataTamu = json_decode($jsonTamu, true);

      return true;
    }
    return false;
  }

  private function populateData() {
    $dataExist = $this->loadTamuFromJSONFile();
    if ($dataExist) {
      # get last key of the array and set it as count
      $lastKey = end(array_keys($this->dataTamu));
      $this->count = $lastKey + 1;
    } else {
      $this->dataTamu = [];
      $this->count = 1;
    }
  }

  private function refreshData() {
    # save and refresh data
    $this->exportTamuToJSON();
    $this->populateData();
  }
}