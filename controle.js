/* Charge le contenu principal de la page */
function loadLst(chemin, tri = undefined) {
    if (tri == undefined)
	tri = $( "#tri option:selected" ).val();

    /* Met à jour le contenu de #lst */
    $('#lst').load('actions.php', 'dir=' + chemin + '&tri=' + tri, 
		   function() {
		       /* Callback pour les clics */
		       $('.bout-rep').click(expandDir);
		       
		       /* Cache les fichiers cachés et décoche la checkbox*/
		       $('.cache').toggle(false);
		       $('#checkCache').prop('checked', false);
		    });
    $('#monPath').val(chemin);
}

/* Clic sur un dossier */
function expandDir(evt) {
    var chemin = evt.target.dataset.path;

    loadLst(chemin);
}

/* Clic sur le bouton UP*/
function butUp(evt) {
    var chemin = $('#elemUp').data('path');

    loadLst(chemin);
}

/* Clic sur le home */
function butHome(evt) {
    var chemin = '/home/vincent';

    loadLst(chemin);
}

/* Changement dans le input ou le tri */
function changeOptions() {
    var chemin = $('#monPath').val();

    loadLst(chemin);
}

/* Checkbox fichiers cachés */
function toggleCaches(evt) {
    $('.cache').toggle();
}

/* Infos sur un fichier */
function majInfos(datas) {
    $("#infosTaille").html(datas[0]);
    $("#infosProprio").html(datas[1]);
    $("#infosGroupe").html(datas[2]);
    $("#infosPerms").html(datas[3]);
    $("#infosType").html(datas[4]);
    $("#infosMod").html(datas[5]);
}

/* La popup des infos sur un fichier */
function prepInfos(evt) {
    var elem = evt.relatedTarget;
    var url = "actions.php?fic=" + elem.dataset.fic;

    $('#infos .modal-header h4').html(elem.dataset.fic);
    
    $.ajax({
	dataType: "json",
	url: url,
	success: majInfos
    });
}

/* Upload d'un fichier */
function upFile(evt) {
    var formData = new FormData();
    var chemin = $('#monPath').val();

    formData.append('fic_chemin', chemin);
    formData.append( 'file', $('#upFile')[0].files[0]);

    /* Declenche le modal avec message d'attente */
    $('#upInfos h4').html("Chargement en cours...");
    $('#upInfos').modal();

    $.ajax({
	type: 'POST',
	url: 'actions.php', 
	data: formData,
	processData: false,
	contentType: false,
	encode: true,
	success: function(data) {
	    /* Maj du modal */
	    if (data != "" && JSON.parse(data)) $('#upInfos h4').html("Fichier uploadé avec succès");
	    else $('#upInfos h4').html("Échec de l'upload");
	    loadLst(chemin);
	},
	error: function() {
	    $('#upInfos h4').html("Échec de l'upload");
	}
    });
}


function init() {
    $('.cache').toggle();

    /* Init des events handlers */
    $('.bout-rep').click(expandDir);
    $('#up').click(butUp);
    $('#home').click(butHome);
    $('#monPath').change(changeOptions);
    
    $('#checkCache').change(toggleCaches);

    $("#infos").on('show.bs.modal', prepInfos);
    $('#tri').change(changeOptions);
    $('#upFile').change(upFile);
}

window.onload = init;
