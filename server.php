<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// conexion a la base de datos
$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTRAR USUARIOS
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // validacion de formulario: asegura que el formulario este correctamente llenado ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Usuario es requerido"); }
  if (empty($email)) { array_push($errors, "Email es requerido"); }
  if (empty($password_1)) { array_push($errors, "Password es requerido"); }
  if ($password_1 != $password_2) {
	array_push($errors, "Las contraseñas no concuerdan!");
  }

  // primero revisa la base de datos para asegurarse 
  // que un usuario no existe con el mismo nombre de usuario y/o correo electronico
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // Si el usuario existe
    if ($user['username'] === $username) {
      array_push($errors, "Ya existe el usuario!");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email ya existe!");
    }
  }

  // Finalmente, registra el usuario si no hay errores en el formulario
  if (count($errors) == 0) {
  	$password = md5($password_1);//encripta la contraseña antes de guardarla en la base de datos

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "Has ingresado exitosamente!";
  	header('location: index.php');
  }
}

// ...

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Nombre de Usuario requerido");
  }
  if (empty($password)) {
    array_push($errors, "un Password es requerido");
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "Has ingresado con exito!";
      header('location: index.php');
    }else {
      array_push($errors, "combinación incorrecta de Usuario/password");
    }
  }
}

?>
