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
      "voorletters",
      "voorvoegsels",
      "achternaam",
      "gebruikersnaam",
      "Wachtwoord"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $voorletters = $_POST['voorletters'];
    $voorvoegsels = $_POST['voorvoegsels'];
    $achternaam = $_POST['achternaam'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $Wachtwoord = $_POST['Wachtwoord'];


    $db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
    $db->create_or_update_medewerker($voorletters, $voorvoegsels, $achternaam, $gebruikersnaam, $Wachtwoord);

      header('location: welcome_user.php');
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
        <legend>Registratie medewerker</legend>
        <input type="text" name="voorletters" placeholder="voorletters" required/>
        <input type="text" name="voorvoegsels" placeholder="voorvoegsels" required/>
        <input type="text" name="achternaam" placeholder="achternaam" required/>
        <input type="text" name="gebruikersnaam" placeholder="gebruikersnaam" required/>
        <input type="password" name="Wachtwoord" placeholder="Wachtwoord" required/>
        <input type="submit" name='submit' value"Sign up!"/>
      </fieldset>
      <a href="welcome_user.php"> home pagina </a>
    </form>
  </body>
</html>
