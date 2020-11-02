<!--Gemaakt door furkan ucar OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: login.php');
    exit;
  }
include 'database.php';

$jongeren= "";
$activiteiten= "";

$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');

foreach($db->get('SELECT id, voornaam, achternaam FROM jongeren') as $jongere){
  $jongeren = $jongeren. 'option value"'.$jongere['id'].'">'.$jongere['voornaam'].' '.$jongere['achternaam'].'</option>';
}
foreach($db->get('SELECT id, omschrijving FROM activiteiten') as $activiteit){
  $activiteiten = $activiteiten. 'option value"'.$activiteit['id'].'">'.$activiteit['omschrijving'].'</option>';
}

if($_SERVER ['REQUEST_METHOD'] == 'POST'){
  $statement = "INSERT INTO koppel(ActiviteitenID, JongerenID) VALUES (:ActiviteitenID, :JongerenID)";
  $db->insert($statement, [
      'ActiviteitenID' => $_POST['activiteiten'],
      'JongerenID' => $_POST['jongeren']
  ]);
      header('location: login.php');
}

?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Registratie scherm</title>
  </head>

  <body>
    <form method="post">

      <legend>Koppelen:</legend><br></br>
      <label for="jongeren">Jongeren:</label>
      <select name="jongeren">
          <?=$jongeren?>
      </select><br></br>

      <label for="activiteiten">Activiteit:</label>

      <select name="activiteiten">
          <?=$activiteiten?>
      </select><br></br>
      <button type="submit" class="btn btn-primary mb-2">Koppelen</button>
    </form>
  </body>
</html>
