	$('#dataViewAsignacionesFamOBPDF').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)

		//$('.alert').hide();//Oculto alert
	})
	$('#AyudaEscolarOBPPDF').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)

		//$('.alert').hide();//Oculto alert
	})
	//----- Imprimir Listado PDF de horas extras ------
	jQuery("#btnayudaescolarobimplistado").click(function(){
		//--------Obtenemos el valor del input
		var tipolistado = jQuery("#cbotlistadoasignacionesfamob").val();
		var tipoasignaciones = jQuery("#cbotipoasignacionesfamob").val();
		var tipolegajos = jQuery("#cbotipolegajoasignacionesfamob").val();
		var ordenasignaciones = jQuery("#cboordenasignacionesfamob").val();
		//var incluirnovedades = jQuery("#inovedadesasignacionesfamob").val();
		if( $('#inovedadesasignacionesfamob').prop('checked') ) {
    	//alert('Seleccionado');
			var incluirnovedades = 1;
		}else{
			var incluirnovedades = 0;
		}

		var params = {
			"TipoListado" : tipolistado,
			"TipoAsignaciones" : tipoasignaciones,
			"TipoLegajos" : tipolegajos,
			"OrdenAsingnaciones" : ordenasignaciones,
			"IncluirNovedades" : incluirnovedades,
		};
		//--------llamada al fichero PHP con AJAX
		$.ajax({
			cache: false,
			type: 'POST',
			//dataType:"html",
			url: 'includes/pdf/ayudaescolar-listado-pdf.php',
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
	$('#dataViewAsignacionesFamPDF').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)

		//$('.alert').hide();//Oculto alert
	})
	//----- Imprimir Listado asignaciones familiares ------
	jQuery("#btnasignacionesfamimplistado").click(function(){
		//--------Obtenemos el valor del input
		var tipolistado = jQuery("#cbotlistadoasignacionesfam").val();
		var tipoasignaciones = jQuery("#cbotipoasignacionesfam").val();
		var tipolegajos = jQuery("#cbotipolegajoasignacionesfam").val();
		var ordenasignaciones = jQuery("#cboordenasignacionesfam").val();
		//var incluirnovedades = jQuery("#inovedadesasignacionesfamob").val();
		if( $('#inovedadesasignacionesfam').prop('checked') ) {
    	//alert('Seleccionado');
			var incluirnovedades = 1;
		}else{
			var incluirnovedades = 0;
		}

		var params = {
			"TipoListado" : tipolistado,
			"TipoAsignaciones" : tipoasignaciones,
			"TipoLegajos" : tipolegajos,
			"OrdenAsingnaciones" : ordenasignaciones,
			"IncluirNovedades" : incluirnovedades,
		};
		//--------llamada al fichero PHP con AJAX
		$.ajax({
			cache: false,
			type: 'POST',
			//dataType:"html",
			url: 'includes/pdf/beneficiariostitulares-listado-pdf.php',
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
