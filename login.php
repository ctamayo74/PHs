<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Ingreso</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Usuario</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Ingresar</button>
  	</div>
  	<p>
  		Aún no eres miembro? <a href="register.php">Registrarse</a>
  	</p>
  </form>
</body>
</html>
