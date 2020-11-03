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
      "fabriekid",
      "product",
      "type",
      "inkoopprijs",
      "verkoopprijs"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $fabriekid = $_POST['fabriekid'];
    $product = $_POST['product'];
    $type = $_POST['type'];
    $inkoopprijs = $_POST['inkoopprijs'];
    $verkoopprijs = $_POST['verkoopprijs'];


    $db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
    $db->create_or_update_artikel($fabriekid, $product, $type, $inkoopprijs, $verkoopprijs);
        header('location: welcome_user.php');
        exit;
    }

}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>artikel toevoegen</title>
  </head>

  <body>
        <form method="post" action='artikel.php' method='post' accept-charset='UTF-8'>
      <fieldset >
        <legend>artikel toevoegen</legend>

        <input type="text" name="fabriekid" placeholder="fabriekid" required/>
        <input type="text" name="product" placeholder="product" required/>
        <input type="text" name="type" placeholder="type" required/>
        <input type="text" name="inkoopprijs" placeholder="inkoopprijs" required/>
        <input type="text" name="verkoopprijs" placeholder="verkoopprijs" required/>
        <input type="submit" name='submit' value"Sign up!"/>
      </fieldset>
      <a href="welcome_user.php"> home pagina </a>
    </form>
  </body>
</html>
