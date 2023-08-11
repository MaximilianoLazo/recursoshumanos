  	//------------ llena formulario edicion --------
	$('#dataUpdateHorasExtras').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)

		$('.alert').hide();//Oculto alert
	})
	$('#dataViewHorasExtrasPDF').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)

		$('.alert').hide();//Oculto alert
	})
	$('#dataViewHorasExtrasExcel').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)

		$('.alert').hide();//Oculto alert
	})
	$('#dataViewHorasExtrasResumenPDF').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget) // Botón que activó el modal
		var titulo = button.data('titulo')

		var modal = $(this)
		modal.find('.modal-title').text(titulo)
		$('.alert').hide();//Oculto alert
	})
	//------ llenado de combos con datos filtrados al cambiar un dato -----
	$("#escuelapais").change(function(){
		$.get("view/get_provincias.php","pais="+$("#escuelapais").val(), function(data){
			$("#escuelaprovincia").html(data);
			console.log(data);
		});
	});
	jQuery(document).ready(function(){
	//$(document).ready(function(){
		//$('#hsextrasdni').change({source:'includes/php/autocompletar_empleado.php', minLength:7});
		$('#hsextrasdni').blur (function(){
			//var valor=$(this).val();
			var valor = jQuery("#hsextrasdni").val();
			$.ajax ({
				url:"includes/php/autocompletar_empleado.php",
				type:"POST",
				dataType:"json",
				data: {val:valor},
				success: function(res){
					$('#hsextrasempleado').val(res.hsexempleado);
					$('#hsextrasltrabajo').val(res.hsexltrabajonombre);
					$('#hddhsexltrabajoid').val(res.hsexltrabajoid);
					$('#hddhsexltrabajonombre').val(res.hddhsexltrabajonombre);
					//$('#empreltipo').val(res.empreltipo);
				}
			})
		})
	});
	jQuery(document).ready(function(){
	//$(document).ready(function(){
		//$('#hsextrasdni').change({source:'includes/php/autocompletar_empleado.php', minLength:7});
		$('#hsextrasdni').blur (function(){
			//var valor=$(this).val();
			var valor = jQuery("#hsextrasdni").val();
			$.ajax ({
				url:"includes/php/autocompletar_horasextras.php",
				type:"POST",
				dataType:"json",
				data: {val:valor},
				success: function(res){
					$('#hsextrassimples').val(res.hsexsimples);
					$('#hsextrasdobles').val(res.hsexdobles);
					$('#hsjornales').val(res.hsjornales);
					$('#hsexobservaciones').val(res.hsobservaciones);
				}
			})
		})
	});
	$(document).ready(function(){
		$("#hsextrasdni").autocomplete({
			source: "?c=horasextras&a=HorasExtrasIngresarAyuda",
			//source: "includes/php/horasextrasingresar-ayuda.php",
			minLength: 3,
			select: function(event, ui){
				event.preventDefault();
				$('#hsextrasdni').val(ui.item.nrodocto);
			 }
		});
  });
	//----- Imprimir Listado PDF de horas extras ------
	jQuery("#btnhorasextrasimplistado").click(function(){
		//--------Obtenemos el valor del input
		var lugardetrabajo = jQuery("#cbolugardetrabajopdf").val();
		var legajotipo = jQuery("#cbotipodelegajopdf").val();
		var ordenhoras = jQuery("#cboordenhorasexpdf").val();

		var params = {
			"LugarDeTrabajo" : lugardetrabajo,
			"LegajoTipo" : legajotipo,
			"OrdenHoras" : ordenhoras,
		};
		//--------llamada al fichero PHP con AJAX
		$.ajax({
			cache: false,
			type: 'POST',
			//dataType:"html",
			url: 'includes/pdf/horasextras-listado.php',
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
	//----- Imprimir Listado PDF de horas extras ------
	jQuery("#btnhorasextrasresumenimplistado").click(function(){
		//--------Obtenemos el valor del input
		var lugardetrabajo = jQuery("#cbolugardetrabajopdf").val();
		var legajotipo = jQuery("#cbotipodelegajopdf").val();
		var ordenhoras = jQuery("#cboordenhorasexpdf").val();

		var params = {
			"LugarDeTrabajo" : lugardetrabajo,
			"LegajoTipo" : legajotipo,
			"OrdenHoras" : ordenhoras,
		};
		//--------llamada al fichero PHP con AJAX
		$.ajax({
			cache: false,
			type: 'POST',
			//dataType:"html",
			url: 'includes/pdf/horasextras-listado-resumen.php',
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
