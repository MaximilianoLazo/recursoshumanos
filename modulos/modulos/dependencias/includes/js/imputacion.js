		//------------- llena formulario de Vista --------
		$('#dataViewEscuela').on('show.bs.modal', function (event){
			var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo')
			var id = button.data('id')
			var escnro = button.data('escnro')
			var escnombre = button.data('escnombre')
			var escdireccion = button.data('escdireccion')
			var escdirecnro = button.data('escdirecnro')
			var escdirecpiso = button.data('escdirecpiso')
			var esccpostal = button.data('esccpostal')
			var esctelefono = button.data('esctelefono')
			var escemail = button.data('escemail')
			var escpais = button.data('escpais')
			var escppdl = button.data('escppdl')

			var modal = $(this)
			modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #escuelaid').val(id)
			modal.find('.dato1').val(escnombre)
			modal.find('.modal-body #escuelanro').val(escnro)
			modal.find('.modal-body #escueladireccion').val(escdireccion)
			modal.find('.modal-body #escueladirecnro').val(escdirecnro)
			modal.find('.modal-body #escueladirecpiso').val(escdirecpiso)
			modal.find('.modal-body #escuelacpostal').val(esccpostal)
			modal.find('.modal-body #escuelatelefono').val(esctelefono)
			modal.find('.modal-body #escuelaemail').val(escemail)
			modal.find('.modal-body #escuelapais').val(escpais)
			modal.find('.modal-body #escuelappdl').val(escppdl)
			$.get("view/get_provincias.php","pais="+$("#escuelappdl").val(), function(data){
			$("#escuelaprovincia").html(data);
			console.log(data);
			});
			$.get("view/get_departamentos.php","provincia="+$("#escuelappdl").val(), function(data){
			$("#escueladepartamento").html(data);
			console.log(data);
			});
			$.get("view/get_localidades.php","departamento="+$("#escuelappdl").val(), function(data){
			$("#escuelalocalidad").html(data);
			console.log(data);
			});
			$('.alert').hide();//Oculto alert
		})
		//------------ llena formulario edicion --------
		$('#dataUpdateImputacion').on('show.bs.modal', function (event){
		  var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo')
			var id = button.data('id')
			var impcodigow = button.data('impcodigow')
			var impcodigos = button.data('impcodigos')
			var impnombre = button.data('impnombre')

		  var modal = $(this)
		  modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #imputacionid').val(id)
			modal.find('.modal-body #imputacioncodigow').val(impcodigow)
			modal.find('.modal-body #imputacioncodigos').val(impcodigos)
			modal.find('.modal-body #imputacionnombre').val(impnombre)
		  $('.alert').hide();//Oculto alert
		})
		//------ llena formulario para eliminacion ------
		$('#dataDeleteImputacion').on('show.bs.modal', function (event){
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var id = button.data('id') // Extraer la información de atributos de datos

			var modal = $(this)
		  modal.find('.modal-body #imputacionid').val(id)
		})
		//---- Llena tabla con empliados de imputacion seleccionada ---
		$('#dataTableViewImputacion').on('show.bs.modal', function (event){
		  var button = $(event.relatedTarget) // Botón que activó el modal
			var titulo = button.data('titulo')
			var id = button.data('id')
			var impcodigow = button.data('impcodigow')
			var impnombre = button.data('impnombre')
			var cupos = button.data('cupos')
			var ocupados = button.data('ocupados')
			var disponibles = button.data('disponibles')

		  var modal = $(this)
		  modal.find('.modal-title').text(titulo)
			modal.find('.modal-body #lblccosto').text(impcodigow)
			modal.find('.modal-body #lblimputacion').text(impnombre)
			modal.find('.modal-body #lblcupos').text(cupos)
			modal.find('.modal-body #lblocupados').text(ocupados)
			modal.find('.modal-body #lbldisponibles').text(disponibles)
			modal.find('.modal-body #imputacioniddos').val(id)
			//--- llenar tabla con datos de imputacion seleccionada ----
			var params = {
				"Id" : id
			};
			//llamada al fichero PHP con AJAX
			$.ajax({
				data:  params,
				url:   'includes/php/imputacion-xempleado.php',
				dataType: 'html',
				type:  'post',
				beforeSend: function () {
					//mostramos gif "cargando"
					//jQuery('#loading_spinner').show();
					//antes de enviar la petición al fichero PHP, mostramos mensaje
					jQuery("#tabladato").html("   Déjame pensar un poco...");
				},
				success:  function (response) {
					//escondemos gif
					//jQuery('#loading_spinner').hide();
					//mostramos salida del PHP
					jQuery("#tabladato").html(response);
				}
			});
		})
		//---- buscar en tabla en tiempo real ----

		//jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------
			jQuery("#search").keyup(function(){
				//$('#search').on('keyup', function(){
				//cogemos el valor del input
				var search = jQuery("#search").val();
				var imputacionid = jQuery("#imputacioniddos").val();

				var params = {
					"search" : search,
					"imputacionid" : imputacionid
				};

				//llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
					url:   'includes/php/search.php',
					dataType: 'html',
					type:  'post',
					beforeSend: function () {
						//mostramos gif "cargando"
						//jQuery('#loading_spinner').show();
						//antes de enviar la petición al fichero PHP, mostramos mensaje
						//jQuery("#tabladato").html("   Déjame pensar un poco...");
					},
					success:  function (response) {
						//escondemos gif
						//jQuery('#loading_spinner').hide();
						//mostramos salida del PHP
						jQuery("#tabladato").html(response);

					}
				});


			});
		//});
