<!--Gemaakt door furkan ucar OITAOO8B -->
<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: index.php');
    exit;
  }

include 'database.php';

$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $db->deleteArtikelen($id);

    // redirect to overview
    header("location: view_edit_delete_artikelen.php");
    exit;
}

  // in case of field values, proceed, execute insert
  if(isset($_POST['export'])){
      $filename = "user_data_export.xls";
      header("Content-Type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=\"$filename\"");
      $print_header = false;

      $result = $db->get_artikel_information(NULL);
      if(!empty($result)){
          foreach($result as $row){
              if(!$print_header){
                  echo implode("\t", array_keys($row)) ."\n";
                  $print_header=true;
              }
              echo implode("\t", array_values($row)) ."\n";
          }
      }
      exit;
  }
  ?>

<html>
  <head>
    <meta charset="utf-8">
    <title>View edit and delete artikelen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        .table-responsive{
            overflow-x: unset !important;
        }
    </style>
  </head>

  <body>

    <div align="center">
        <legend> View edit and delete artikelen</legend>
        <a class="btn btn-success" href="index.php">Home</a> |
        <a class="btn btn-warning" href="artikel_toevoegen.php">artikelen toevoegen</a>
    </div> <br><br>

    <?php

        // admin should be able to see all users. should not filter on user, hence the NULL.
        $results = $db->get_artikel_information(NULL);

        // get the first index of results, which is an associative array.
        $columns = array_keys($results[0]);
        ?>

    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>View edit and delete artikelen</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                          <?php foreach($columns as $column){ ?>
                              <th><strong> <?php echo $column ?> </strong></th>
                          <?php } ?>
                          <th colspan="2">action</th>
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
                            <td>
                                <a class="btn btn-info" href="artikelwijzigen.php?user_id=<?php echo $row_id; ?>&id=<?php echo $row['id']?>" class="edit_btn" >Edit</a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="view_edit_delete_artikelen.php?user_id=<?php echo $row_id; ?>&id=<?php echo $row['id']?>" class="del_btn">Delete</a>
                            </td>
                      </tr>
                    <?php } ?>
              </table>
              <form action='view_edit_delete_artikelen.php' method='POST'>
                  <input type='submit' name='export' value='Export to excel file' />
              </form>
            </body>
        </html>
