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

    public function create_or_update_medewerker($voorletters, $voorvoegsels, $achternaam, $gebruikersnaam, $wachtwoord){
      $query = "INSERT INTO medewerker
            (id, voorletters, voorvoegsels, achternaam, gebruikersnaam, wachtwoord)
            VALUES
            (NULL, :voorletters, :voorvoegsels, :achternaam, :gebruikersnaam, :wachtwoord)";

      $statement = $this->pdo->prepare($query);

      // password hashen
      $hashed_password =  password_hash($pass, PASSWORD_DEFAULT);

      $statement->execute([
        'voorletters'=>$voorletters,
        'voorvoegsels'=>$voorvoegsels,
        'achternaam'=>$achternaam,
        'gebruikersnaam'=>$gebruikersnaam,
        'wachtwoord'=>$hashed_password
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    public function create_or_update_fabriek($fabriek, $telefoon){
      $query = "INSERT INTO fabriek
            (id, fabriek, telefoon)
            VALUES
            (NULL, :fabriek, :telefoon)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'fabriek'=>$fabriek,
        'telefoon'=>$telefoon
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    public function create_or_update_artikel($fabriekid, $product, $type, $inkoopprijs, $verkoopprijs){
      $query = "INSERT INTO artikel
            (id, fabriekid, product, type, inkoopprijs, verkoopprijs)
            VALUES
            (NULL, :fabriekid, :product, :type, :inkoopprijs, :verkoopprijs)";

      $statement = $this->pdo->prepare($query);

      $statement->execute([
        'fabriekid'=>$fabriekid,
        'product'=>$product,
        'type'=>$type,
        'inkoopprijs'=>$inkoopprijs,
        'verkoopprijs'=>$verkoopprijs,
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $medewerker_id = $this->pdo->lastInsertId();
      return $medewerker_id;
    }

    public function remove_artikel($id){
      $query = "DELETE FROM artikel WHERE id = :id";

      $statement = $this->pdo->prepare($query);
      $statement->execute([
        'id'=>$id
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $artikel_id = $this->pdo->lastInsertId();
      return $artikel_id;
    }

    public function create_or_update_locatie($locatie){
      $query = "INSERT INTO locatie
            (id, locatie)
            VALUES
            (NULL, :locatie)";

      $statement = $this->pdo->prepare($query);
      $statement->execute([
        'locatie'=>$locatie
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $locatie_id = $this->pdo->lastInsertId();
      return $locatie_id;
    }

    public function create_or_update_voorraad($locatieID, $artikelID, $aantal){
      $query = "INSERT INTO voorraad
            (id, locatieID, artikelID, aantal)
            VALUES
            (NULL, :locatieID, :artikelID, :aantal)";

      $statement = $this->pdo->prepare($query);
      $statement->execute([
        'locatieID'=>$locatieID,
        'artikelID'=>$artikelID,
        'aantal'=>$aantal

      ]);

      // haalt de laatst toegevoegde id op uit de db
      $voorraad_id = $this->pdo->lastInsertId();
      return $voorraad_id;
    }

      public function authenticate_user($gebruikersnaam, $wachtwoord){

          $query = "SELECT wachtwoord
          FROM medewerker
          WHERE gebruikersnaam = :gebruikersnaam";

          $stmt = $this->pdo->prepare($query);
          // voorbereide instructieobject wordt uitgevoerd.
          $stmt->execute(['gebruikersnaam' => $gebruikersnaam]); //-> araay
          $result = $stmt->fetch(); // returned een array

          // checkt of $result een array is
          if(is_array($result)){
          // voerd count uit als #result een array is
          if(count($result) > 0){

          $hashed_password = $result['wachtwoord'];

          if($gebruikersnaam && password_verify($pass, $hashed_password)){
              session_start();
              // slaat userdata in sessie veriable
              $_SESSION['gebruikersnaam'] = $gebruikersnaam;
              $_SESSION['loggedin'] = true;

              echo "testing 123787";
              header("location: welcome_user.php");
          }
      }
    }
  }
}
?>
