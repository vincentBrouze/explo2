function loadLst(chemin) {

    $('#lst').load('actions.php', 'dir=' + chemin, 
		    function() {
			$('.bout-rep').click(expandDir);
			$('.cache').toggle(false);
			$('#checkCache').prop('checked', false);
		    });
    $('#monPath').val(chemin);
}

function expandDir(evt) {
    var chemin = evt.target.dataset.path;


    loadLst(chemin);
}

function butUp(evt) {
    var chemin = $('#elemUp').data('path');

    loadLst(chemin);
}

function butHome(evt) {
    var chemin = '/home/vincent';

    loadLst(chemin);
}


function changePath() {
    var chemin = $('#monPath').val();

    loadLst(chemin);
}

function toggleCaches(evt) {
    $('.cache').toggle();
}


function majInfos(datas) {
    console.log("Infos récupérées");

    $("#infosTaille").html(datas[0]);
    $("#infosProprio").html(datas[1]);
    $("#infosGroupe").html(datas[2]);
    $("#infosPerms").html(datas[3]);
    $("#infosType").html(datas[4]);
    $("#infosMod").html(datas[5]);

    return;
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

function init() {
    $('.cache').toggle();
    $('.bout-rep').click(expandDir);
    $('#up').click(butUp);
    $('#home').click(butHome);
    $('#monPath').change(changePath);
    
    $('#checkCache').change(toggleCaches);

    $("#infos").on('show.bs.modal', prepInfos);
}

window.onload = init;
