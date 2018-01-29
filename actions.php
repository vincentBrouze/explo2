<?php
require('vues.php');

function update_lst($dir, $tri, $ordre) {
  print_ls($dir, $tri, $ordre);
}


/* Convertit les permission en chaines de caractère type 'll' */
function human_mod($perms) {
  if (($perms & 0xC000) == 0xC000) {
    // Socket
    $info = 's';
  } elseif (($perms & 0xA000) == 0xA000) {
    // Lien symbolique
    $info = 'l';
  } elseif (($perms & 0x8000) == 0x8000) {
    // Régulier
    $info = '-';
  } elseif (($perms & 0x6000) == 0x6000) {
    // Block special
    $info = 'b';
  } elseif (($perms & 0x4000) == 0x4000) {
    // Dossier
    $info = 'd';
  } elseif (($perms & 0x2000) == 0x2000) {
    // Caractère spécial
    $info = 'c';
  } elseif (($perms & 0x1000) == 0x1000) {
    // pipe FIFO
    $info = 'p';
  } else {
    // Inconnu
    $info = 'u';
}
  
  // Autres
  $info .= (($perms & 0x0100) ? 'r' : '-');
  $info .= (($perms & 0x0080) ? 'w' : '-');
  $info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));
  
  // Groupe
  $info .= (($perms & 0x0020) ? 'r' : '-');
  $info .= (($perms & 0x0010) ? 'w' : '-');
  $info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));
  
  // Tout le monde
  $info .= (($perms & 0x0004) ? 'r' : '-');
  $info .= (($perms & 0x0002) ? 'w' : '-');
  $info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));

return $info;
}

function getFileInfos($fic) {
  $datas = array();

  $infos = @stat($fic);
  $type = @mime_content_type($fic);

  $datas[0] = human_filesize($infos["size"]);
  $datas[1] = @posix_getpwuid($infos["uid"])['name'];
  $datas[2] = @posix_getgrgid($infos["gid"])['name'];
  
  $perms = fileperms($fic);
  $datas[3] = human_mod($perms);
  $datas[4] = $type;
  $datas[5] = gmdate("d/m/Y H:i:s", $infos["mtime"]);

  $msg = json_encode($datas);
  echo $msg;
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