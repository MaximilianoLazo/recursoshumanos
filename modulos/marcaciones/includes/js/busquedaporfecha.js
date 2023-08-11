	function load(page){

	}
	$('#dataConstanciaHijo').on('show.bs.modal', function(event){
	//$(document).on('click', '.view_data', function(){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var employee_id = button.data('id') // Extraer la información de atributos de datos

		//$('#employee_detail').html(employee_id)
		//var employee_id = $(this).attr("id");
		/*
		if(employee_id != ''){


		 $.ajax({

			url:"includes/php/listadohijos-constancia.php",
			method:"POST",
			data:{employee_id:employee_id},
			success:function(data){
				$('#employee_detail').html(data);
				//$('#dataModal').modal('show');
				$('#dataConstanciaHijo').modal('show');
			}
		 });

		}
		*/
	});

	$('#dataUpdateHijo').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var id = button.data('id') // Extraer la información de atributos de datos
		var hijotdoc = button.data('hijotdoc') // Extraer la información de atributos de datos
		var hijondoc = button.data('hijondoc') // Extraer la información de atributos de datos
		var hijoapellido = button.data('hijoapellido') // Extraer la información de atributos de datos
		var hijonombres = button.data('hijonombres') // Extraer la información de atributos de datos
		var hijonrocuil = button.data('hijonrocuil') // Extraer la información de atributos de datos
		var hijosexo = button.data('hijosexo') // Extraer la información de atributos de datos
		var hijofecnacto = button.data('hijofecnacto') // Extraer la información de atributos de datos
		var hijodireccion = button.data('hijodireccion') // Extraer la información de atributos de datos
		var hijodirecnro = button.data('hijodirecnro') // Extraer la información de atributos de datos
		var hijodirecpiso = button.data('hijodirecpiso') // Extraer la información de atributos de datos
		var hijocodpostal = button.data('hijocodpostal') // Extraer la información de atributos de datos
		var hijoppdl = button.data('hijoppdl') // Extraer la información de atributos de datos
		var hijopais = button.data('hijopais') // Extraer la información de atributos de datos
		var hijoprovincia = button.data('hijoprovincia') // Extraer la información de atributos de datos
		var hijodepartamento = button.data('hijodepartamento') // Extraer la información de atributos de datos
		var hijolocalidad = button.data('hijolocalidad') // Extraer la información de atributos de datos
		var hijodisc = button.data('hijodisc') // Extraer la información de atributos de datos
		var hijoesc = button.data('hijoesc') // Extraer la información de atributos de datos
		var hijoescnom = button.data('hijoescnom') // Extraer la información de atributos de datos
		var hijoescnvl = button.data('hijoescnvl') // Extraer la información de atributos de datos
		var hijoescest = button.data('hijoescest') // Extraer la información de atributos de datos
		var hijomoptdoc = button.data('hijomoptdoc') // Extraer la información de atributos de datos
		var hijomopndoc = button.data('hijomopndoc') // Extraer la información de atributos de datos
		var hijomopapellido = button.data('hijomopapellido') // Extraer la información de atributos de datos
		var hijomopnombres = button.data('hijomopnombres') // Extraer la información de atributos de datos
		var hijobentdoc = button.data('hijobentdoc') // Extraer la información de atributos de datos
		var hijobenndoc = button.data('hijobenndoc') // Extraer la información de atributos de datos
		var hijobennoficio = button.data('hijobennoficio') // Extraer la información de atributos de datos
		var hijobenapellido = button.data('hijobenapellido') // Extraer la información de atributos de datos
		var hijobennombres = button.data('hijobennombres') // Extraer la información de atributos de datos
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var empid = button.data('empid') // Extraer la información de atributos de datos
		var empnrodocto = button.data('empnrodocto') // Extraer la información de atributos de datos

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #id').val(id)
		modal.find('.modal-body #hijotdoc').val(hijotdoc)
		modal.find('.modal-body #hijondoc').val(hijondoc)
		modal.find('.modal-body #hijoapellido').val(hijoapellido)
		modal.find('.modal-body #hijonombres').val(hijonombres)
		modal.find('.modal-body #hijonrocuil').val(hijonrocuil)
		modal.find('.modal-body #hijosexo').val(hijosexo)
		modal.find('.modal-body #hijofecnacto').val(hijofecnacto)
		modal.find('.modal-body #hijodireccion').val(hijodireccion)
		modal.find('.modal-body #hijodirecnro').val(hijodirecnro)
		modal.find('.modal-body #hijodirecpiso').val(hijodirecpiso)
		modal.find('.modal-body #hijocodpostal').val(hijocodpostal)
		modal.find('.modal-body #hijoppdl').val(hijoppdl)
		modal.find('.modal-body #hijopais').val(hijopais)
		//modal.find('.modal-body #hijoprovincia').val(hijoprovincia)
		//modal.find('.modal-body #hijodepartamento').val(hijodepartamento)
		//modal.find('.modal-body #hijolocalidad').val(hijolocalidad)
		$.get("includes/php/obtener_provincias.php","pais="+hijoppdl, function(data){
			$("#hijoprovincia").html(data);
			console.log(data);
		});
		$.get("includes/php/obtener_departamentos.php","provincia="+hijoppdl, function(data){
			$("#hijodepartamento").html(data);
			console.log(data);
		});
		$.get("includes/php/obtener_localidades.php","departamento="+hijoppdl, function(data){
			$("#hijolocalidad").html(data);
			console.log(data);
		});

		if (hijodisc == 1) {
			modal.find('.modal-body #hijodisc').prop('checked', true);
		}else{
			modal.find('.modal-body #hijodisc').prop('checked', false);
		}
		if (hijoesc == 1) {
			modal.find('.modal-body #hijoesc').prop('checked', true);
		}else{
			modal.find('.modal-body #hijoesc').prop('checked', false);
		}
		modal.find('.modal-body #hijoescnom').val(hijoescnom)
		modal.find('.modal-body #hijoescnvl').val(hijoescnvl)
		modal.find('.modal-body #hijoescest').val(hijoescest)
		modal.find('.modal-body #hijomoptdoc').val(hijomoptdoc)
		modal.find('.modal-body #hijomopndoc').val(hijomopndoc)
		modal.find('.modal-body #hijomopapellido').val(hijomopapellido)
		modal.find('.modal-body #hijomopnombres').val(hijomopnombres)
		modal.find('.modal-body #hijobentdoc').val(hijobentdoc)
		modal.find('.modal-body #hijobenndoc').val(hijobenndoc)
		modal.find('.modal-body #hijonrooficio').val(hijobennoficio)
		modal.find('.modal-body #hijobenapellido').val(hijobenapellido)
		modal.find('.modal-body #hijobennombres').val(hijobennombres)
		modal.find('.modal-body #empid').val(empid)
		modal.find('.modal-body #empnrodocto').val(empnrodocto)
		//$('.alert').hide();//Oculto alert
	})
	$('#dataUpdateAsignacionDes').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var id = button.data('id') // Extraer la información de atributos de datos
		var empid = button.data('empid')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #hijoid').val(id)
		modal.find('.modal-body #empid').val(empid)
	})
	$('#dataUpdateAsignacionHab').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo') // Extraer la información de atributos de datos
		var id = button.data('id') // Extraer la información de atributos de datos
		var empid = button.data('empid')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		modal.find('.modal-body #hijoid').val(id)
		modal.find('.modal-body #empid').val(empid)
	})
	$('#dataUpdateFichadaDia').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Botón que activó el modal
		var id = button.data('id') // Extraer la información de atributos de datos
		var empid = button.data('empid')
		var modal = $(this)
		modal.find('.modal-body #hijoid').val(id)
		modal.find('.modal-body #empid').val(empid)
	})
	//---- Al cambiar datos-----
	$("#hijopais").change(function(){
		$.get("includes/php/obtener_provincias.php","pais="+$("#hijopais").val(), function(data){
			$("#hijoprovincia").html(data);
			console.log(data);
		});
	});
	$("#hijoprovincia").change(function(){
		$.get("includes/php/obtener_departamentos.php","provincia="+$("#hijoprovincia").val(), function(data){
			$("#hijodepartamento").html(data);
			console.log(data);
		});
	});
	$("#hijodepartamento").change(function(){
		$.get("includes/php/obtener_localidades.php","departamento="+$("#hijodepartamento").val(), function(data){
			$("#hijolocalidad").html(data);
			console.log(data);
		});
	});

	jQuery("#BtnListarContratos").click(function(){
		//--------Obtenemos el valor del input
		//var nrodnis = jQuery('input:checkbox:checked').val();
		var nrodnis = [];
		console.log($("input[name='checkbox[]']"));
		$("input[name='checkbox[]']:checked").each(function(){
			console.log($(this).val());
			nrodnis .push($(this).val());
		});
		//var nrodnis = jQuery("#checkbox").val();
		//var historicodi = jQuery("#mbusquedahistoricodi").val();
		//var historicodf = jQuery("#mbusquedahistoricodf").val();
		var params = {
			"NroDnis" : nrodnis,
		};
		//--------llamada al fichero PHP con AJAX
		$.ajax({
			cache: false,
			type: 'POST',
			//dataType:"html",
			url: 'includes/pdf/constanciaescolar.php',
			//contentType: false,
			//processData: false,
			data: params,
			//xhrFields is what did the trick to read the blob to pdf
			xhrFields:{
				responseType: 'blob'
			},
			success: function (response, status, xhr){
				var filename = "";
				var disposition = xhr.getResponseHeader('Content-Disposition');

				if(disposition){
					var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
					var matches = filenameRegex.exec(disposition);
					if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
				}
				var linkelem = document.createElement('a');
				try{
					var blob = new Blob([response], { type: 'application/octet-stream' });

					if(typeof window.navigator.msSaveBlob !== 'undefined'){
						//   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were creaThese URLs will no longer resolve as the data backing the URL has been freed."
						window.navigator.msSaveBlob(blob, filename);
					}else{
						var URL = window.URL || window.webkitURL;
						var downloadUrl = URL.createObjectURL(blob);

						if (filename){
							// use HTML5 a[download] attribute to specify filename
							var a = document.createElement("a");

							// safari doesn't support this yet
							if(typeof a.download === 'undefined'){
								window.location = downloadUrl;
							}else{
								a.href = downloadUrl;
								a.download = filename;
								document.body.appendChild(a);
								a.target = "_blank";
								a.click();
							}
						}else{
							window.location = downloadUrl;
						}
					}

				}catch(ex){
					console.log(ex);
				}
			}
		});
	});
	var checked = false;

	//$('#customCheck1').on('click',function(){
		$(document).on('click', '.check-all', function(){

	  if(checked == false){
	    $('.check-cont').prop('checked', true);
	    checked = true;
	  }else{
	    $('.check-cont').prop('checked', false);
	    checked = false;
	  }
	});
