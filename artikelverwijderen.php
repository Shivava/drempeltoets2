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
      "id"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $id = $_POST['id'];


    $db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
    $db->remove_artikel($id);
        // header('location: welcome_user.php');
        // exit;
    }

}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>artikel toevoegen</title>
  </head>

  <body>
        <form method="post" action='artikelverwijderen.php' method='post' accept-charset='UTF-8'>
      <fieldset >
        <legend>artikel verwijderen</legend>

        <input type="text" name="id" placeholder="artikel id" required/>
        <input type="submit" name='submit' value"Sign up!"/>
      </fieldset>
      <a href="welcome_user.php"> home pagina </a>
    </form>
  </body>
</html>
