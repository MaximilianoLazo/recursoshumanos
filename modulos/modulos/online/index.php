
<!DOCTYPE html>
<html>
	<head>
		<title>USUARIOS ONLINE</title>
		<link rel="stylesheet" href="css/estilo.css">
		<script stype="text/javascript" src="js/online.js"></script>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	</head>
	<body><br>
		<center><h1>USUARIOS ONLINE</h1></center><br>	
		<div class="tabs">
   <div class="tab">
       <input type="radio" id="tab-1" name="tab-group-1" checked>
       <label for="tab-1">Inciar Sesi&oacuten</label>
       <div class="content">
       <form name="form1" onsubmit="login(); return false" method="POST">
				<div id="mensaje"></div>	

						<input type="text" name="email" placeholder="Usuario"required><br>
						<input type="password" name="password" placeholder="Password" required>
						<input type="hidden" name="iniciar" value="ok">						
						<input type="submit" value="Entrar"><br>			
			</form>
       </div>
   </div>
   <div class="tab">
       <input type="radio" id="tab-2" name="tab-group-1">
       <label for="tab-2">Registrar</label>
       <div class="content">
			<form name="nuevo_user" onsubmit="enviar(); return false" enctype="multipart/form-data">
					<div id="res"></div>	
					<input type="text" name="email" placeholder="Usuario" required  id="email" >
					<input type="password" name="password" placeholder="Password" required>
					<input type="text" name="nombre" placeholder="Nombre Completo" required>
					<input type="hidden" name="ap" value="">Fotograf&iacutea
					<input type="file" name="fotos" required id="archivo">			
					<input type="hidden" name="tipo" value="1">
					<input type="hidden" name="nomfoto" id="nomfoto" value="">
					<input type="submit" value="Crear"><br>
				</form>
				<script src="js/test.js"></script>
        </div>
   </div>
</div>		
	</body>
</html>

