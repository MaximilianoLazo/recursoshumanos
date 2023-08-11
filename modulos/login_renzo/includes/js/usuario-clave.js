$('#UsrEditarClave').on('shown.bs.modal', function (event) {
	
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var usrid = button.data('usrid')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddusuarioid').val(usrid)
	modal.find('.modal-body #txtclavenueva').val(usrid)

	$(".modal-body #txtclientegnrodoc").focus();
	

})

$(document).ready(function() {
	alert("Hola");
	$('#txtclavenueva').keyup(function() {
		alert("Holasolo");
	});

	/*$('#txtclavenueva, #txtclavenuevarep').on('keyup', function() {
		alert("HOLA");

	});*/

});