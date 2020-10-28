<!--Gemaakt door furkan ucar OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: login.php');
    exit;
  }
include 'database.php';
include 'HelperFunctions.php';

if(isset($_POST['submit'])){

  // maak een array met alle name attributes
  $fields = [
      "voornaam",
      "achternaam",
      "email"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];

    $db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
    $db->create_or_update_medewerker($voornaam, $achternaam, $email);


        header('location: login.php');
        exit;
    }
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Registratie scherm</title>
  </head>

  <body>
      <form method="post" action='register.php' method='post' accept-charset='UTF-8'>
      <fieldset >
        <legend>Registratie</legend>
        <input type="text" name="voornaam" placeholder="voornaam" required/>
        <input type="text" name="achternaam" placeholder="achternaam" required/>
        <input type="email" name="email" placeholder="email" required/>
        <input type="submit" name='submit' value"Sign up!"/>
      </fieldset>
    </form>
  </body>
</html>
