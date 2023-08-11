
	$('#dataUpdatePreNatal').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var prenid = button.data('prenid')
		var empid = button.data('empid') // Extraer la información de atributos de datos
		var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos
		var bennrodocto = button.data('bennrodocto')
		var prenatalfecum = button.data('prenatalfecum')
		var prenatalfecpp = button.data('prenatalfecpp')


		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #hddprenatalid').val(prenid)
		modal.find('.modal-body #empid').val(empid)
		modal.find('.modal-body #empnrodocto').val(empnrodocto)
		modal.find('.modal-body #bennrodocto').val(bennrodocto)
		modal.find('.modal-body #txtprenatalfecum').val(prenatalfecum)
		modal.find('.modal-body #txtprenatalfecpp').val(prenatalfecpp)

		//$('.alert').hide();//Oculto alert
	})
	$('#dataUpdatePreNatalOld').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var id = button.data('id') // Extraer la información de atributos de datos
		var hijoprebentdoc = button.data('hijoprebentdoc') // Extraer la información de atributos de datos
		var hijoprebenndoc = button.data('hijoprebenndoc') // Extraer la información de atributos de datos
		var hijoprebennoficio = button.data('hijoprebennoficio')
		var hijoprebenapellido = button.data('hijoprebenapellido') // Extraer la información de atributos de datos
		var hijoprebennombres = button.data('hijoprebennombres') // Extraer la información de atributos de datos
		var hijopremadretdoc = button.data('hijopremadretdoc') // Extraer la información de atributos de datos
		var hijopremadrendoc = button.data('hijopremadrendoc') // Extraer la información de atributos de datos
		var hijopremadreapellido = button.data('hijopremadreapellido') // Extraer la información de atributos de datos
		var hijopremadrenombres = button.data('hijopremadrenombres') // Extraer la información de atributos de datos
		var hijoprefecum = button.data('hijoprefecum')
		var hijoprefecpp = button.data('hijoprefecpp')
		var empid = button.data('empid') // Extraer la información de atributos de datos
		var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #id').val(id)
		modal.find('.modal-body #txthijoprefecum').val(hijoprefecum)
		modal.find('.modal-body #txthijoprefecpp').val(hijoprefecpp)
		modal.find('.modal-body #cbohijopremoptdoc').val(hijopremadretdoc)
		modal.find('.modal-body #txthijopremopndoc').val(hijopremadrendoc)
		modal.find('.modal-body #txthijoprebennoficio').val(hijoprebennoficio)
		modal.find('.modal-body #txthijopremopapellido').val(hijopremadreapellido)
		modal.find('.modal-body #txthijopremopnombres').val(hijopremadrenombres)
		modal.find('.modal-body #cbohijoprebentdoc').val(hijoprebentdoc)
		modal.find('.modal-body #txthijoprebenndoc').val(hijoprebenndoc)
		modal.find('.modal-body #txthijoprebenapellido').val(hijoprebenapellido)
		modal.find('.modal-body #txthijoprebennombres').val(hijoprebennombres)
		modal.find('.modal-body #empid').val(empid)
		modal.find('.modal-body #empnrodocto').val(empnrodocto)
		//$('.alert').hide();//Oculto alert
	})
	$('#dataDeletePreNatal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var prenid = button.data('prenid') // Extraer la información de atributos de datos
		var empid = button.data('empid')
		var empndoc = button.data('empndoc')
		var benndoc = button.data('benndoc')

		var modal = $(this)
		modal.find('.modal-body #prenatalid').val(prenid)
		modal.find('.modal-body #empid').val(empid)
		modal.find('.modal-body #hddempndoc').val(empndoc)
		modal.find('.modal-body #hddbenndoc').val(benndoc)
	})
	$('#UpdateBeneficiarioPreNatal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var prenid = button.data('prenid')
		var empid = button.data('empid')
		var empndoc = button.data('empndoc')
		var benndoc = button.data('benndoc')
		//-----datos exclusivos de boton editar
		var prenbenndoc = button.data('prenbenndoc')
		var prenbennoficio = button.data('prenbennoficio')
		var prenbenapellido = button.data('prenbenapellido')
		var prenbennombres = button.data('prenbennombres')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #prenatalbenid').val(prenid)
		modal.find('.modal-body #empbenid').val(empid)
		modal.find('.modal-body #hddpernempnrodocto').val(empndoc)
		modal.find('.modal-body #hddpernbennrodocto').val(benndoc)
		modal.find('.modal-body #prenatalbenndoc').val(prenbenndoc)
		modal.find('.modal-body #prenatalnbennoficio').val(prenbennoficio)
		modal.find('.modal-body #prenatalbenapellido').val(prenbenapellido)
		modal.find('.modal-body #prenatalbennombres').val(prenbennombres)

	})
	$('#UpdatemopPreNatal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal

		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var prenmopid = button.data('prenmopid')
		var empmopid = button.data('empmopid')
		var prenmopndoc = button.data('prenmopndoc')
		var prenmopapellido = button.data('prenmopapellido')
		var prenmopnombres = button.data('prenmopnombres')


		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #prenatalmopid').val(prenmopid)
		modal.find('.modal-body #empmopid').val(empmopid)
		modal.find('.modal-body #prenatalmopndoc').val(prenmopndoc)
		modal.find('.modal-body #prenatalmopapellido').val(prenmopapellido)
		modal.find('.modal-body #prenatalmopnombres').val(prenmopnombres)

	})
	$('#dataDisablePreNatal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var prenid = button.data('prenid') // Extraer la información de atributos de datos
		var empid = button.data('empid')
		var empndoc = button.data('empndoc')
		var benndoc = button.data('benndoc')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #prenataldesid').val(prenid)
		modal.find('.modal-body #empid').val(empid)
		modal.find('.modal-body #hddempndoc').val(empndoc)
		modal.find('.modal-body #hddbenndoc').val(benndoc)
	})
	$('#dataEnablePreNatal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var prenid = button.data('prenid') // Extraer la información de atributos de datos
		var empid = button.data('empid')
		var empndoc = button.data('empndoc')
		var benndoc = button.data('benndoc')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #prenataldesid').val(prenid)
		modal.find('.modal-body #empid').val(empid)
		modal.find('.modal-body #hddpnhempndoc').val(empndoc)
		modal.find('.modal-body #hddpnhbenndoc').val(benndoc)
	})
	jQuery(document).ready(function(){
		$('#prenatalbenndoc').blur (function(){
			var valor = jQuery("#prenatalbenndoc").val();
			$.ajax ({
				url:"?c=empleado&a=BeneficiarioAutocompletar",
				type:"POST",
				dataType:"json",
				data: {val:valor},
				success: function(res){
					//--- Datos del beneficiario
					$('#hddprenatalbenid').val(res.hjobenid);
					$('#prenatalbenapellido').val(res.hjobenapellido);
					$('#prenatalbennombres').val(res.hjobennombres);
				}
			})
		})
	});
