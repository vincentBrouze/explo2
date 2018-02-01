<?php
error_reporting(E_ERROR | E_PARSE);

function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

/* */
$assoc_mime = array('directory' => 'icone-repertoire.png',
		    'application/pdf' => 'icone-pdf.png',
		    );

function icone_mime($mime) {
$assoc_mime = array('directory' => 'icone-repertoire.png',
		    'application/pdf' => 'icone-pdf.png',
		    );  

  if (isset($assoc_mime[$mime])) return $assoc_mime[$mime];
  else return 'icone-fichier.png';
}

function comp_fic($tri, $ordre) {
  if (($tri == 'nom' || $tri == 'type') && $ordre == 'asc') {
    return function($a, $b) use($tri) {
      return strcmp($a[$tri], $b[$tri]);
    };  
  } else if (($tri == 'nom' || $tri == 'type') && $ordre == 'desc') {
    return function($a, $b) use($tri) {
      return strcmp($b[$tri], $a[$tri]);
    };
  } else if (($tri == 'taille' || $tri == 'date') && $ordre == 'desc') {
    return function($a, $b) use($tri) {
      return $b[$tri] - $a[$tri];
    };    
  }
  else if (($tri == 'taille' || $tri == 'date') && $ordre == 'asc') {
    return function($a, $b) use($tri) {
      return $a[$tri] - $b[$tri];
    };    
  }
}

function build_tab($rep, $dir, $tri, $ordre) {
  $lst = array();
  $i = 0;

  /* Parcourt le répertoire pour 
     construire un tableau
  */
  foreach ($dir as $idx => $nom) {
    $nomComp = $rep.'/'.$nom;
    if (fileperms($nomComp) & 0x0004) {
      $infos = stat($nomComp);
      $type = mime_content_type($nomComp);
      
      $lst[$i]['nom'] = $nom;
      $lst[$i]['type'] = mime_content_type($nomComp);
      $lst[$i]['icone'] = icone_mime($lst[$i]['type']);
      $lst[$i]['taille'] = $infos["size"];
      $lst[$i]['date'] = $infos["mtime"];
      $i++;
    }
  }

  /* Trie le tableau en fonction des critères donnés */
  usort($lst, comp_fic($tri, $ordre));
  return $lst;
}



/* Imprime la liste des fichiers du répertoire */
function print_ls($rep, $tri = 'nom', $ordre = 'asc') {
  $lst = build_tab($rep, scandir($rep), $tri, $ordre);
  
  /*print_r($lst);*/

  if ($dir = scandir($rep)) {
    $lst = build_tab($rep, scandir($rep), $tri, $ordre);
    foreach ($lst as $idx => $elem) {
      if ($elem['nom'] != '.') { 
	$cache="";
	if (substr($elem['nom'], 0, 1) == '.' && $elem['nom'] != '..') {
	  $cache = " cache";
	}

	echo "<article class='col-6 col-sm-4 col-md-3 col-lg-2 fic $cache'>";

	if (strlen($elem['nom']) > 15) {
	  $nom=substr($elem['nom'], 0, 15).'...';
	} else {
	  $nom = $elem['nom'];
	}

	$chemin = $rep.'/'.$elem['nom'];
	if (is_dir($chemin)){
	  $id = '';
	  $chemin = $rep.'/'.$elem['nom'];
	  if ($rep == '/') {
	    $chemin = '/'.$elem['nom'];
	  }
	  if ($elem['nom'] == '..') {
	    $id = "id='elemUp'";
	    $chemin = dirname($rep);
	  }
	  echo "<img $id class='bout-rep' data-path='".$chemin."' src='".$elem['icone']."'/>";
	} else {
	  echo "<img data-fic='$chemin' data-toggle='modal' data-target='#infos' src='".$elem['icone']."'/>";
	}
	echo "<p>".$nom."</p>";
	echo "</article>";
      }
    }
  }
}

?>