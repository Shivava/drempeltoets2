<?php
// initialiseer de sessie
session_start();

//kijkt of er een account ingelogd is, zo niet dan word ie redirected naar login.php
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: login.php');
    exit;
}
?>

<html>
    <head>
        <title>Welcome!</title>
    </head>
    <body>
        <div class="topnav">
            <a class="active" href="welcome_user.php">Home</a>
            <a href="user.php">fabriek toevoegen</a>
            <a href="locatie.php">locatie toevoegen</a>
            <a href="voorraad.php">voorraad</a>
            <a href="artikel.php">artikel toevoegen</a>
            <a href="artikelverwijderen.php">artikel verwijderen</a>
            <a href="register.php">account registreren</a>
            <a href="logout.php">Logout</a>
        </div>
        <?php echo "Welcome " . htmlentities( $_SESSION['gebruikersnaam']) ."!" ?>

    </body>
</html>
