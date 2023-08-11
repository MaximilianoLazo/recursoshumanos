//----- Ventana modal Fichadas tanda - Editar---
$('#FichadasTandaEditar').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var tandaid = button.data('tandaid')
	var tandanom = button.data('tandanom')
	var tandafd = button.data('tandafd')
	var tandafh = button.data('tandafh')
	var tandafp = button.data('tandafp')

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddfictide').val(tandaid)
	modal.find('.modal-body #txtfichtntandae').val(tandanom)
	modal.find('.modal-body #txtfictfecdesdee').val(tandafd)
	modal.find('.modal-body #txtfictfechastae').val(tandafh)
	modal.find('.modal-body #txtfictfecprocesoe').val(tandafp)

	$('.alert').hide();//Oculto alert

})
$('#FichadasTandaArchivar').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var mtandaid = button.data('tandaid') // Extraer la información de atributos de datos
	//var mtandadetalleid = button.data('mtandadetalleid') // Extraer la información de atributos de datos
	/*var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddmartandaide').val(mtandaid)
	/*modal.find('.modal-body #hddmtandadetalleide').val(mtandadetalleid)*/

	$('.alert').hide();//Oculto alert

})
//----- Ventana modal Fichadas tanda - Importar---
$('#FichadasTandaImportar').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var mtandaid = button.data('mtandaid') // Extraer la información de atributos de datos
	/*var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddmtandaide').val(mtandaid)
	/*modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)*/

	$('.alert').hide();//Oculto alert

})
$('#FichadasTandaDetallesBaja').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var mtandaid = button.data('mtandaid') // Extraer la información de atributos de datos
	var mtandadetalleid = button.data('mtandadetalleid') // Extraer la información de atributos de datos
	/*var empid = button.data('empid') // Extraer la información de atributos de datos
	var empnrodocto = button.data('empnrodocto')*/

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddmtandaide').val(mtandaid)
	modal.find('.modal-body #hddmtandadetalleide').val(mtandadetalleid)

	$('.alert').hide();//Oculto alert

})
//----- Ventana modal Fichadas tanda detalles - Agregar empleado individual---
$('#FichadasTandaDetallesGuardar').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) // Botón que activó el modal
	var titulo = button.data('titulo') // Extraer la información de atributos de datos
	var mtandaid = button.data('mtandaid') // Extraer la información de atributos de datos

	var modal = $(this)
	modal.find('.modal-header .modal-title').text(titulo)
	modal.find('.modal-body #hddfictandaide').val(mtandaid)
	$("#btnfictandadetalleguardar").prop('disabled', true);

	$(".alert").show();
	//$('.alert').hide();//Oculto alert

})
$( "#txtfictandadetallednieditar" ).keyup(function() {
	var cardnumber = $("#txtfictandadetallednieditar").val();
	if (cardnumber.length > 6 && cardnumber.length < 10) {
		 var valor = $("#txtfictandadetallednieditar").val();
		 $.ajax ({
 			url:"?c=marcacion&a=FichadasTandaDetallesEditarAutocompletar",
 			type:"POST",
 			dataType:"json",
 			data: {val:valor},
 			success: function(res){
				var condicion = res.condicion;
				if(condicion == 1){
					$('#hddfictandadetalleltrabajoide').val(res.fictdetalletrabajoid);
					$('#hddfictandadetallesecrtariaide').val(res.fictdetallesecretariaid);
					$('#hddfictandadetallerelojide').val(res.fictdetallerelojid);
					$('.lblfictandadetalleapellidoeditar').text(res.empapellido);
					$('.lblfictandadetallenombreseditar').text(res.empnombres);
					$('.lblfictandadetalleltrabajoeditar').text(res.fictdetalletrabajonombre);
					$('.lblfictandadetallesecrtariaeditar').text(res.fictdetallesecretarianombre);
					$('.lblfictandadetallerelojeditar').text(res.fictdetallerelojnombre);
					$("#btnfictandadetalleguardar").prop('disabled', false);
				}else{
					$('.lblfictandadetalleapellidoeditar').text("-");
					$('.lblfictandadetallenombreseditar').text("-");
					$('.lblfictandadetalleltrabajoeditar').text("-");
					$('.lblfictandadetallesecrtariaeditar').text("-");
					$('.lblfictandadetallerelojeditar').text("-");
					$("#btnfictandadetalleguardar").prop('disabled', true);
				}
 			}
 		})
	}
});
function uploadme(){
	var cardnumber = $("#txtfictandadetallednieditar").val();
	if (cardnumber.length > 6 && cardnumber.length < 10) {
		 var valor = $("#txtfictandadetallednieditar").val();
		 $.ajax ({
 			url:"?c=marcacion&a=FichadasTandaDetallesEditarAutocompletar",
 			type:"POST",
 			dataType:"json",
 			data: {val:valor},
 			success: function(res){
				var condicion = res.condicion;
				if(condicion == 1){
					$('#hddfictandadetalleltrabajoide').val(res.fictdetalletrabajoid);
					$('#hddfictandadetallesecrtariaide').val(res.fictdetallesecretariaid);
					$('#hddfictandadetallerelojide').val(res.fictdetallerelojid);
					$('.lblfictandadetalleapellidoeditar').text(res.empapellido);
					$('.lblfictandadetallenombreseditar').text(res.empnombres);
					$('.lblfictandadetalleltrabajoeditar').text(res.fictdetalletrabajonombre);
					$('.lblfictandadetallesecrtariaeditar').text(res.fictdetallesecretarianombre);
					$('.lblfictandadetallerelojeditar').text(res.fictdetallerelojnombre);
					$("#btnfictandadetalleguardar").prop('disabled', false);
				}else{
					$('.lblfictandadetalleapellidoeditar').text("-");
					$('.lblfictandadetallenombreseditar').text("-");
					$('.lblfictandadetalleltrabajoeditar').text("-");
					$('.lblfictandadetallesecrtariaeditar').text("-");
					$('.lblfictandadetallerelojeditar').text("-");
					$("#btnfictandadetalleguardar").prop('disabled', true);
				}
 			}
 		})
	}
};
/*$(document).ready(function(){
	$("#txtfictandadetallednieditar").autocomplete({
		source: "?c=marcacion&a=FichadasTandaDetallesEditarHelp",
		//source: "includes/php/horasextrasingresar-ayuda.php",
		minLength: 3,
		select: function(event, ui){
			event.preventDefault();
			$('#txtfictandadetallednieditar').val(ui.item.nrodocto);
			uploadme();
		 }
	});
});*/

$(document).ready(function(){
	$('#txtfictandadetallednieditar').typeahead({
		minLength: 3,
    source: function(query, process){
      return $.ajax({
        //url: $('#txtfictandadetallednieditar').data('?c=marcacion&a=FichadasTandaDetallesEditarHelp'),
				url: "?c=marcacion&a=FichadasTandaDetallesEditarHelp",
        type: 'post',
        data: {query: query},
        dataType: 'json',
        success: function(result){
          var resultList = result.map(function(item){
            var aItem = {id: item.Id, name: item.Name};
            return JSON.stringify(aItem);
          });
          return process(resultList);
        }
      });
    },
		matcher: function(obj){
      var item = JSON.parse(obj);
      return ~item.name.toLowerCase().indexOf(this.query.toLowerCase())
    },
    sorter: function(items){
      var beginswith = [], caseSensitive = [], caseInsensitive = [], item;
      while (aItem = items.shift()){
        var item = JSON.parse(aItem);
        if (!item.name.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(JSON.stringify(item));
        else if (~item.name.indexOf(this.query)) caseSensitive.push(JSON.stringify(item));
        else caseInsensitive.push(JSON.stringify(item));
      }
      return beginswith.concat(caseSensitive, caseInsensitive)
    },
    highlighter: function(obj){
      var item = JSON.parse(obj);
      var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
      return item.name.replace(new RegExp('(' + query + ')', 'ig'), function($1, match){
      	return '<strong>' + match + '</strong>'
      })
    },
    updater: function(obj){
      var item = JSON.parse(obj);
      //$('#txtfictandadetallednieditar').attr('value', item.id);
			$('.modal-body #txtfictandadetallednieditar').val(item.id);
			uploadme();
      return item.id;

    }
	});
});
