<?php
error_reporting(E_ERROR | E_PARSE);

/* Change une taille en octets en taille human readable */
function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
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

/* Tableau d'association entre type mime et icone */
$assoc_mime = array('directory' => 'icone-repertoire.png',
		    'application/pdf' => 'icone-pdf.png',
		    );

/* Renvoie un nom de fichieer iucone en fonction du type mime */
function icone_mime($mime) {
$assoc_mime = array('directory' => 'icone-repertoire.png',
		    'application/pdf' => 'icone-pdf.png',
		    );  

  if (isset($assoc_mime[$mime])) return $assoc_mime[$mime];
  else return 'icone-fichier.png';
}

/* Fonction de comparaison selon les criteres $tri et $ordre 
   a utiliser avec usort()
*/
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

/* Renvoie un tableau des fichiers de $rep */
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



/* Imprime la liste des fichiers du répertoire
   Triée selon $tri et $ordre
 */
function print_ls($rep, $tri = 'nom', $ordre = 'asc') {

  $lst = build_tab($rep, scandir($rep), $tri, $ordre);  

  if ($dir = scandir($rep)) {
    $lst = build_tab($rep, $dir, $tri, $ordre);
    /* Parcourt le tableau des fichiers et genere le code HTML */
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