<?php
require('vues.php');

/* Gere une requete d'upload 
   imprime true ou false en JSON
   selon réussite ou echec.
*/
function upFile() {
  $chemin = $_POST['fic_chemin'];
  $dest = $chemin.'/'.basename($_FILES['file']['name']);
  
  if (move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
    echo json_encode(true);
  } else {
    echo json_encode(false);
  }
}

/* Mise à jour du contenu principal : renvoie le code html à intégrer 
   à la page
*/
function update_lst($dir, $tri, $ordre) {
  print_ls($dir, $tri, $ordre);
}


/* Contruit et imprime au format JSON un tableau
   des infos sur un fichier :
   - taille 
   - proprio
   - groupe
   - permissions
   - type mime
   - date dernière modification 
 */
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

/* Gere les parametre et determine l'action a effectuer en fonction */
if (isset($_GET['fic'])) {
  /* Infos Fichiers*/
  getFileInfos($_GET['fic']);
} else if (isset($_POST['fic_chemin'])) {
  /* Upload */
  upFile();
} else if (isset($_GET['dir'])){
  /* Maj lst */
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