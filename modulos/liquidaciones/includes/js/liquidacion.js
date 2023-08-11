$(document).ready(function () {
  $('#LiquidacionPrevia').on('show.bs.modal', function (event){
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    /*var mtandaid = button.data('mtandaid') // Extraer la información de atributos de datos*/
    /*var empid = button.data('empid') // Extraer la información de atributos de datos
    var empnrodocto = button.data('empnrodocto')*/
    var jubper = button.data('periodo')

    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #hddper').val(jubper)
    /*modal.find('.modal-body #hddmtandaide').val(mtandaid)*/
    /*modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)*/

    $('.alert').hide();//Oculto alert

  })

  $('#LiquidacionFinal').on('show.bs.modal', function (event){
    var button = $(event.relatedTarget) // Botón que activó el modal
    var titulo = button.data('titulo') // Extraer la información de atributos de datos
    /*var mtandaid = button.data('mtandaid') // Extraer la información de atributos de datos*/
    /*var empid = button.data('empid') // Extraer la información de atributos de datos
    var empnrodocto = button.data('empnrodocto')*/
    var jubper = button.data('peri')

    var modal = $(this)
    modal.find('.modal-header .modal-title').text(titulo)
    modal.find('.modal-body #hddper').val(jubper)
    /*modal.find('.modal-body #hddmtandaide').val(mtandaid)*/
    /*modal.find('.modal-body #hddempnrodoctoe').val(empnrodocto)*/

    $('.alert').hide();//Oculto alert

  })

    $('#AltaNovedad').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Botón que activó el modal
        var titulo = button.data('titulo') // Extraer la información de atributos de datos
        var jubidtar1 = button.data('jubidtar')
        var jubper = button.data('periodo')

        var modal = $(this)
        modal.find('.modal-header .modal-title').text(titulo)
        modal.find('.modal-body #hddjub').val(jubidtar1)
        modal.find('.modal-body #hddper').val(jubper)

      })

      $('#AltaNovedadxtanda').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Botón que activó el modal
        var titulo = button.data('titulo') // Extraer la información de atributos de datos

        var jubper = button.data('periodo')

        var modal = $(this)
        modal.find('.modal-header .modal-title').text(titulo)
         modal.find('.modal-body #hddper').val(jubper)

      })

      $('#dataTableViewReciboxmes').on('show.bs.modal', function (event){
        var button = $(event.relatedTarget) // Botón que activó el modal
          var titulo = button.data('titulo')
          var id1 = button.data('id')
          //var id2 = button.data('per')

          var modal = $(this)
          modal.find('.modal-title').text(titulo)
          modal.find('.modal-body #reciboxmes').val(id1)
          //modal.find('.modal-body #reciboiddos1').val(id2)

             //llamada al fichero PHP con AJAX
                $.get("?c=liquidacion&a=ReciboxEmpxmes",{Id: $("#reciboxmes").val()}, function(data){
                jQuery("#tabladatorecibo").html(data);
            });

      })

      //---- Llena tabla con empliados de imputacion seleccionada ---
      $('#dataTableViewRecibo').on('show.bs.modal', function (event){
        var button = $(event.relatedTarget) // Botón que activó el modal
          var titulo = button.data('titulo')
          var id1 = button.data('id')

          var modal = $(this)
          modal.find('.modal-title').text(titulo)
          modal.find('.modal-body #reciboiddos').val(id1)

             //llamada al fichero PHP con AJAX
                $.get("?c=liquidacion&a=ReciboxEmp",{Id: $("#reciboiddos").val()}, function(data){
                jQuery("#tabladatorecibo").html(data);
            });

      })

      //jQuery(document).ready(function(){
			//--- resultado en vivo de marcaciones ---------

		//});
  });

  jQuery("#BtnImprimirPases").click(function() {
    //
    var tid1 = jQuery("#reciboiddos").val();

    //--------llamada al fichero PHP con AJAX
    $.ajax({
      cache: false,
      type: 'POST',
      //dataType:"html",
      url: '?c=liquidacion&a=ReciboOTPDF',
      //contentType: false,
      //processData: false,
      data: {
        tid: tid1
      },
      //xhrFields is what did the trick to read the blob to pdf
      xhrFields: {
        responseType: 'blob'
      },
      success: function(response, status, xhr) {
        var filename = "";
        var disposition = xhr.getResponseHeader('Content-Disposition');

        if (disposition) {
          var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
          var matches = filenameRegex.exec(disposition);
          if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
        }
        var linkelem = document.createElement('a');
        try {
          var blob = new Blob([response], {
            type: 'application/octet-stream'
          });

          if (typeof window.navigator.msSaveBlob !== 'undefined') {
            //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were creaThese URLs will no longer resolve as the data backing the URL has been freed."
            window.navigator.msSaveBlob(blob, filename);
          } else {
            var URL = window.URL || window.webkitURL;
            var downloadUrl = URL.createObjectURL(blob);

            if (filename) {
              // use HTML5 a[download] attribute to specify filename
              var a = document.createElement("a");

              // safari doesn't support this yet
              if (typeof a.download === 'undefined') {
                window.location = downloadUrl;
              } else {
                a.href = downloadUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.target = "_blank";
                a.click();
              }
            } else {
              window.location = downloadUrl;
            }
          }

        } catch (ex) {
          console.log(ex);
        }
      }
    });
  });
