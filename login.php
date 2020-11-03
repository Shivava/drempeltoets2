<!-- Furkan ucar OITAOO8B -->
<?php

// session_start();
//
// if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
//     header('location: login.php');
//     exit;
//   }

include 'database.php';
include 'helperfunctions.php';


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && !empty($_POST['submit'])){
  // maak een array met alle name attributes

  $fields = [
    	"gebruikersnaam",
    	"wachtwoord"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
if($no_error){
  $gebruikersnaam = $_POST['gebruikersnaam'];
  $wachtwoord = $_POST['wachtwoord'];

  $db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
  $db->authenticate_user($wachtwoord, $gebruikersnaam);
}
}

 ?>


<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>login pagina</title>
	</head>
	<body>
		<form id='login' action='login.php' method='post' accept-charset='UTF-8'>
			<fieldset >
				<legend>Login</legend>
				<input type="text" name="gebruikersnaam" placeholder="gebruikersnaam" required/>
				<input type="password" name="wachtwoord" placeholder="wachtwoord" required/>
				<input type='submit' name="submit" value='submit' />
			</fieldset>
		  	<p>
		  		Not a member? <a href="register.php">register</a>
		  	</p>
		</form>
	</body>
</html>
