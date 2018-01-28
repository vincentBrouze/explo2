<?php
require('vues.php');

function update_lst($dir, $tri, $ordre) {
  print_ls($dir, $tri, $ordre);
}

function getFileInfos($fic) {
  
}

if (isset($_GET['fic'])) {
  getFileInfos($_GET['fic']);
} else {
  $dir='/home/vincent';
  if (isset($_GET['dir'])) {
    $dir = $_GET['dir'];
  }
  $tri='nom';
  if (isset($_GET['tri'])) {
    $tri = $_GET['tri'];
  }
  
  $ordre='asc';
  if (isset($_GET['ordre'])) {
    $ordre = $_GET['ordre'];
  }

  update_lst($dir, $tri, $ordre);
}

?>