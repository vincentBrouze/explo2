<?php

require('vues.php');
$repBase = '/home/vincent';
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
  <nav id="nav" class="row col-12 ">
  <button class='btn col-1' id='up'><i class="fa fa-arrow-up"></i></button>
  <button class='btn col-1' id='home'><i class="fas fa-home"></i></button>
  <input id='monPath' value='<?php echo $repBase; ?>' class='form-control col-9' type='text'></intput>
  <input class='form' id='checkCache' type="checkbox"></input>Afficher les fichiers cachés.
  
  </nav>
   <section id="lst" class="row">
<?php
   print_ls('/home/vincent');

?>
</section>
  </main>

<div class="modal fade" id="infos" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
     <div class="modal-body">
  <table class="table">
  <tbody>
  <tr><th>Taille :</th><td>1.32Mo</td></tr>
  <tr><th>Propriétaire :</th><td>vincent</td></tr>
  <tr><th>Groupe :</th><td>vincent</td></tr>
  <tr><th>Permissions :</th><td>rwxr-xr-x</td></tr>
  <tr><th>Type :</th><td>text/plain</td></tr>
  <tr><th>Modifié le :</th><td>19/01/2018 9h42:23s</td></tr>
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