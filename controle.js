function loadLst(chemin, tri = 'nom') {

    $('#lst').load('actions.php', 'dir=' + chemin + '&tri=' + tri, 
		    function() {
			$('.bout-rep').click(expandDir);
			$('.cache').toggle(false);
			$('#checkCache').prop('checked', false);
		    });
    $('#monPath').val(chemin);
}

function expandDir(evt) {
    var chemin = evt.target.dataset.path;
    var tri = $( "#tri option:selected" ).val();;

    loadLst(chemin, tri);
}

function butUp(evt) {
    var chemin = $('#elemUp').data('path');
    var tri = $( "#tri option:selected" ).val();;

    loadLst(chemin, tri);
}

function butHome(evt) {
    var chemin = '/home/vincent';
    var tri = $( "#tri option:selected" ).val();;

    loadLst(chemin, tri);
}


function changePath() {
    var chemin = $('#monPath').val();
    var tri = $( "#tri option:selected" ).val();;

    loadLst(chemin, tri);
}

function changeTri(evt) {
    var chemin = $('#monPath').val();
    var tri = $( "#tri option:selected" ).val();;

    loadLst(chemin, tri);
}

function toggleCaches(evt) {
    $('.cache').toggle();
}


function majInfos(datas) {
    $("#infosTaille").html(datas[0]);
    $("#infosProprio").html(datas[1]);
    $("#infosGroupe").html(datas[2]);
    $("#infosPerms").html(datas[3]);
    $("#infosType").html(datas[4]);
    $("#infosMod").html(datas[5]);
}

function prepInfos(evt) {
    var elem = evt.relatedTarget;
    var url = "actions.php?fic=" + elem.dataset.fic;

    console.log("modal show");
    $('#infos .modal-header h4').html(elem.dataset.fic);
    
    $.ajax({
	dataType: "json",
	url: url,
	success: majInfos
    });
}

function upFile(evt) {
    var formData = new FormData();
    var chemin = $('#monPath').val();

    formData.append('fic_chemin', chemin);
    formData.append( 'file', $('#upFile')[0].files[0]);

    
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
	    if (data != "" && JSON.parse(data)) $('#upInfos h4').html("Fichier uploadé avec succès");
	    else $('#upInfos h4').html("Échec de l'upload");
	    //$('#upInfos').modal();
	    loadLst(chemin);
	},
	error: function() {
	    $('#upInfos h4').html("Échec de l'upload");
	}
    });
}

function init() {
    $('.cache').toggle();
    $('.bout-rep').click(expandDir);
    $('#up').click(butUp);
    $('#home').click(butHome);
    $('#monPath').change(changePath);
    
    $('#checkCache').change(toggleCaches);

    $("#infos").on('show.bs.modal', prepInfos);
    $('#tri').change(changeTri);
    $('#upFile').change(upFile);
}

window.onload = init;
