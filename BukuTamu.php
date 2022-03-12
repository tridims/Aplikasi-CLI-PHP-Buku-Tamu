<?php

require_once "php-cli-colors.php";

class BukuTamu {
  private $dataTamu;
  private $count;
  private $colors;

  public function __construct() {
    $this->populateData();
    $this->colors = new Colors();
  }

  public function getCount() {
    return $this->count;
  }

  public function addTamu($nama, $alamat) {
    $this->dataTamu[$this->count] = [
      'nama' => $nama,
      'alamat' => $alamat
    ];
    // $this->count++;
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
    echo $this->colors->getColoredString($output, "green");
    // echo $output;
  }

  public function deleteTamu($index) {
    unset($this->dataTamu[$index]);
    refreshData();
  }

  public function modifyTamu($index, $nama, $alamat) {
    $this->dataTamu[$index] = [
      'nama' => $nama,
      'alamat' => $alamat
    ];
    refreshData();
  }

  private function exportTamuToJSON() {
    $jsonTamu = json_encode($this->dataTamu);
    
    # write to file
    $file = fopen('tamu.json', 'w');
    fwrite($file, $jsonTamu);
  }

  private function loadTamuFromJSONFile() {
    # check if file exists
    if (file_exists('tamu.json')) {
      # read from file
      $file = fopen('tamu.json', 'r');
      $jsonTamu = fread($file, filesize('tamu.json'));
      fclose($file);

      # decode json
      $this->dataTamu = json_decode($jsonTamu, true);

      return true;
    }
    return false;
  }

  private function populateData() {
    $dataExist = $this->loadTamuFromJSONFile();
    if ($dataExist) {
      # set counter to the number of data in the JSON file
      $this->count = count($this->dataTamu);
    } else {
      $this->dataTamu = [];
      $this->count = 0;
    }
  }

  private function refreshData() {
    # save and refresh data
    $this->exportTamuToJSON();
    $this->populateData();
  }
}