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


    loadLst(chemin);/*
    $('#lst').load('actions.php', 'dir=' + chemin, 
		    function() {
			$('.bout-rep').click(expandDir);
			$('.cache').toggle();
		    });
    $('#monPath').val(chemin);*/
}

function butUp(evt) {
    var chemin = $('#elemUp').data('path');

    loadLst(chemin);/*
    $('#lst').load('actions.php', 'dir=' + chemin, 
		    function() {
			$('.bout-rep').click(expandDir);
			$('.cache').toggle();
		    });
    $('#monPath').val(chemin);
*/
}

function butHome(evt) {
    var chemin = '/home/vincent';

    loadLst(chemin);/*
    $('#lst').load('actions.php', '', 
		    function() {
			$('.bout-rep').click(expandDir);
			$('.cache').toggle();
		    });

    $('#monPath').val(chemin);*/
}


function changePath() {
    var chemin = $('#monPath').val();

    loadLst(chemin);/*
    $('#lst').load('actions.php', 'dir=' + chemin, 
		    function() {
			$('.bout-rep').click(expandDir);
			$('.cache').toggle();
		    });
    */
}

function toggleCaches(evt) {
    $('.cache').toggle();
}

function prepInfos(evt) {
    var elem = evt.relatedTarget;

    console.log("modal show");
    $('#infos .modal-header h4').html("Nom de fichier");
    
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
