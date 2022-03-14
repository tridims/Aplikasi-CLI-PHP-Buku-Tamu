<?php

class BukuTamu {
  private $dataTamu;

  public function __construct() {
    $this->populateData();
  }

  public function addTamu($nama, $alamat) {
    # check if array $dataTamu is empty
    if (empty($this->dataTamu)) {
      $this->dataTamu[1] = [
        'nama' => $nama,
        'alamat' => $alamat
      ];
    } else {
      $this->dataTamu[] = [
        'nama' => $nama,
        'alamat' => $alamat
      ];
    }

    $this->refreshData();
  }

  public function getDaftarTamu() {
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

  public function getJumlahTamu() {
    return count($this->dataTamu);
  }

  public function deleteTamu($index) {
    unset($this->dataTamu[$index]);
    $this->rearrangeArrayIndex();
    $this->refreshData();
  }

  public function rearrangeArrayIndex() {
    $count = 1;
    $temp = [];
    foreach ($this->dataTamu as $key => $value) {
      $temp[$count] = $value;
      $count++;
    };
    $this->dataTamu = $temp;
  }

  public function modifyTamu($index, $nama, $alamat) {
    $this->dataTamu[$index] = [
      'nama' => $nama,
      'alamat' => $alamat
    ];
    $this->refreshData();
  }

  private function exportTamuToJSON() {
    # encode array to json
    $jsonTamu = json_encode($this->dataTamu);
    # save to file
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
    if (!$dataExist or empty($this->dataTamu) or !isset($this->dataTamu)) {
      $this->dataTamu = [];
    } 
  }

  private function refreshData() {
    # save and refresh data
    $this->exportTamuToJSON();
    $this->populateData();
  }
}