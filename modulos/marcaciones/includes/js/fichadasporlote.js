	$("#CboSecretarias").change(function(){
		$.get("includes/php/obtener_lugaresdetrabajo2.php","secretaria="+$("#CboSecretarias").val(), function(data){
			$("#CboLugaresDeTrabajo").html(data);
			console.log(data);
		});
	});
