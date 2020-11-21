<!--Gemaakt door furkan ucar OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: index.php');
    exit;
  }
include 'database.php';
include 'HelperFunctions.php';

$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $voorletters = $_GET['voorletters'];
  $achternaam = $_GET['voorvoegsels'];
  $achternaam = $_GET['achternaam'];

  // redirect to overview
  header("location: edit_user.php");
  exit;
}

if(isset($_POST['submit'])){

  // maak een array met alle name attributes
  $fields = [
      "id",
      "voorletters",
      "voorvoegsels",
      "achternaam"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $id = $_POST['id'];
    $voorletters = $_POST['voorletters'];
    $voorvoegsels = $_POST['voorvoegsels'];
    $achternaam = $_POST['achternaam'];


    $db->editUser($id, $voorletters, $voorvoegsels, $achternaam);

      header('location: edit_user.php');
      exit;
    }
  }
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>medewerker wijzigen</title>
  </head>

  <body>
    <div align="center">
        <legend> medewerker wijzigen</legend>
        <a class="btn btn-success" href="index.php">Home</a> |
        <a class="btn btn-info" href="view_edit_delete_medewerker.php">Show medewerker details</a>
    </div> <br><br>

    <?php

        // admin should be able to see all users. should not filter on user, hence the NULL.
        $results = $db->view_user_detail(NULL);

        // get the first index of results, which is an associative array.
        $columns = array_keys($results[0]);
        ?>

    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>medewerker wijzigen</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                          <?php foreach($columns as $column){ ?>
                              <th><strong> <?php echo $column ?> </strong></th>
                          <?php } ?>
                        </tr>
                    </thead>
                    <?php foreach($results as $rows => $row){ ?>
                        <?php $row_id = $row['id']; ?>
                        <tr>
                            <?php foreach($row as $row_data){?>
                                <td>
                                    <?php echo $row_data ?>
                                </td>
                            <?php } ?>
                      </tr>
                    <?php } ?>
              </table>
              <form method="post" align="center" action='edit_user.php' method='post' accept-charset='UTF-8'>
                <fieldset>
                  <input type="text" name="id" placeholder="id" required/>
                  <input type="text" name="voorletters" placeholder="voorletters" required/>
                  <input type="text" name="voorvoegsels" placeholder="voorvoegsels" required/>
                  <input type="text" name="achternaam" placeholder="achternaam" required/>
                  <button class="btn btn-outline-success" type="submit" name="submit" value="Sign up!">Update!</button>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
    </body>
  </html>
