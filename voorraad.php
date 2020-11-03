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
      "locatieID",
      "artikelID",
      "aantal"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $locatieID = $_POST['locatieID'];
    $artikelID = $_POST['artikelID'];
    $aantal = $_POST['aantal'];

    $db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
    $db->create_or_update_voorraad($locatieID, $artikelID, $aantal);

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
      <form method="post" action='voorraad.php' method='post' accept-charset='UTF-8'>
      <fieldset >
        <legend>voorraad</legend>
        <input type="text" name="locatieID" placeholder="locatieID" required/>
        <input type="text" name="artikelID" placeholder="artikelID" required/>
        <input type="text" name="aantal" placeholder="aantal" required/>
        <input type="submit" name='submit' value"Sign up!"/>
      </fieldset>
      <a href="welcome_user.php"> home pagina </a>
    </form>
  </body>
</html>
