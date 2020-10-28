<!--Gemaakt door furkan ucar OITAOO8B -->
  <?php
  //class database aan gemaakt
  class database{
    // class met allemaal private variables aangemaakt (property)
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    // maakt class constants (admin en user)
    const ADMIN = 1; // these are the values from the db
    const USER = 2;

    public function __construct($host, $user, $pass, $db, $charset){
      $this->host = $host;
      $this->user = $user;
      $this->pass = $pass;
      $this->charset = $charset;

      try {
          $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
          $options = [
              PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              PDO::ATTR_EMULATE_PREPARES   => false,
          ];

          $this->pdo = new PDO($dsn, $user, $pass, $options);
      } catch (\PDOException $e) {
          echo $e->getMessage();
          throw $e;
          // throw new \PDOException($e->getMessage(), (int)$e->getCode());
      }
    }

    // helper functie om te kijken of al een account bestaad zodat er geen twee accounts kunnen aangemaakt worden
    // private function is_new_account($username){
    //     //controlleerd of de naam al erin is
    //     $stmt = $this->db->prepare('SELECT * FROM account WHERE username=:username');
    //     $stmt->execute(['username'=>$username]);
    //     $result = $stmt->fetch();
    //
    //     if(is_array($result) && count($result) > 0){
    //         return false;
    //     }
    //     //als het true result betekent dat een account al bestaat
    //     return true;
    // }

    public function create_or_update_medewerker($voornaam, $achternaam, $email){
      $query = "INSERT INTO medewerker
            (id, voornaam, achternaam, email)
            VALUES
            (NULL, :voornaam, :achternaam, :email)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'voornaam'=>$voornaam,
        'achternaam'=>$achternaam,
        'email'=>$email
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    public function create_or_update_activiteit($omschrijving){
      $query = "INSERT INTO activiteiten
            (id, omschrijving)
            VALUES
            (NULL, :omschrijving)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'omschrijving'=>$omschrijving,
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    public function authenticate_user($email){

        $query = "SELECT email
        FROM medewerker
        WHERE email = :email";

        $stmt = $this->pdo->prepare($query);
        // voorbereide instructieobject wordt uitgevoerd.
        $stmt->execute(['email' => $email]); //-> araay
        $result = $stmt->fetch(); // returned een array
        // checkt of $result een array is
        if(is_array($result)){
        // voerd count uit als #result een array is
        if(count($result) > 0){

        session_start();

        // slaat userdata in sessie veriable
        $_SESSION['email'] = $email;
        $_SESSION['loggedin'] = true;

        echo "testing 123787";
        header("location: welcome_user.php");
        }
      }
    }
}
?>
