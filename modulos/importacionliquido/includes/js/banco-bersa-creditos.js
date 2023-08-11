$('#BancoBersaCredImportar').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	/*var mtandaid = button.data('mtandaid') // Extraer la información de atributos de datos*/
	/*var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	/*modal.find('.modal-body #hddmtandaide').val(mtandaid)*/
	/*modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)*/

	$('.alert').hide();//Oculto alert

})

$('#BancoBersaCredImportarCuil').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	/*var mtandaid = button.data('mtandaid') // Extraer la información de atributos de datos*/
	/*var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	/*modal.find('.modal-body #hddmtandaide').val(mtandaid)*/
	/*modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)*/

	$('.alert').hide();//Oculto alert

})

$('#BancoBersaCredImportarFondo').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	/*var mtandaid = button.data('mtandaid') // Extraer la información de atributos de datos*/
	/*var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	/*modal.find('.modal-body #hddmtandaide').val(mtandaid)*/
	/*modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)*/

	$('.alert').hide();//Oculto alert

})
$('#BancoBersaCredImportar2').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var perio=button.data('perio')
	/*var mtandaid = button.data('mtandaid') // Extraer la información de atributos de datos*/
	/*var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddper').val(perio)

	/*modal.find('.modal-body #hddmtandaide').val(mtandaid)*/
	/*modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)*/

	$('.alert').hide();//Oculto alert

})

$('#BancoBersaCredImportar3').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var perio=button.data('perio')
	/*var mtandaid = button.data('mtandaid') // Extraer la información de atributos de datos*/
	/*var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddper').val(perio)

	/*modal.find('.modal-body #hddmtandaide').val(mtandaid)*/
	/*modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)*/

	$('.alert').hide();//Oculto alert

})
