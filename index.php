<?php
require('vues.php');
$repBase = '/home';
?>

<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bs/css/bootstrap.css" >
  <link href="fontawesome-free-5.0.4/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
   <title>Explorateur de fichiers</title>
  </head>
  <body>
  <header><h1>Explorateur</h1></header>
   <main class="container">


  <nav id="nav" >
  <div id="ligneNav">
  <button class='form-control btn' id='up'><i class="fa fa-arrow-up"></i></button>
  <button class='form-control btn' id='home'><i class="fas fa-home"></i></button>
  <input id='monPath' value='<?php echo $repBase; ?>' class='form-control' type='text'></intput>
  </div>
  <input id='checkCache' type="checkbox"></input>
  <label class="form-check-label" for="checkCache">Afficher les fichiers cachés</label>
  <div>
  <label class="form-check-label" for="choixTri">Trier les fichiers par:</label>
  <select id='tri' class="form-control">
  <option value='nom'>Nom</option>
  <option value='type'>Type</option>
  <option value='date'>Date</option>
  </select>
  </div> 
  <label class="form-check-label">Uploader un fichier:</label>
  <input id='upFile' type="file"></input>
  </nav>
   <section id="lst" class="row">

<?php
  /* Premier chargement */
   print_ls($repBase);

?>
</section>
  </main>

<!-- Div du dialogue resultat upload-->
<div class="modal fade" id="upInfos" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Div du dialogue infos fichiers-->
<div class="modal fade" id="infos" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
      </div>
     <div class="modal-body">
  <table class="table">
  <tbody>
  <tr><th>Taille :</th><td id="infosTaille"></td></tr>
  <tr><th>Propriétaire :</th><td id="infosProprio"></td></tr>
  <tr><th>Groupe :</th><td id="infosGroupe"></td></tr>
  <tr><th>Permissions :</th><td id="infosPerms"></td></tr>
  <tr><th>Type :</th><td id="infosType"></td></tr>
  <tr><th>Modifié le :</th><td id="infosMod"></td></tr>
  </tbody>
</table>
     </div>
   <div class="modal-footer">
     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
</div>
</div>

   <script src="jquery-3.3.1.min.js"></script>
  <script src="bs/js/bootstrap.js "></script>
   <script src="controle.js"></script>
</body>
</html>