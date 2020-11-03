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
      "fabriek",
      "telefoon"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $fabriek = $_POST['fabriek'];
    $telefoon = $_POST['telefoon'];

    $db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
    $db->create_or_update_fabriek($fabriek, $telefoon);


        header('location: welcome_user.php');
        exit;
    }

}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>fabriek toevoegen</title>
  </head>

  <body>
      <form method="post" action='user.php' method='post' accept-charset='UTF-8'>
      <fieldset >
        <legend>Activiteiten toevoegen</legend>
        <input type="text" name="fabriek" placeholder="fabriek" required/>
        <input type="text" name="telefoon" placeholder="telefoon" required/>
        <input type="submit" name='submit' value"Sign up!"/>
      </fieldset>
      <a href="welcome_user.php"> home pagina </a>
    </form>
  </body>
</html>
