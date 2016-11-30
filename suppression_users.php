<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>
<?php
if(!empty($_GET['id'])){
      //récupération de la variable d'URL,
        //qui va nous permettre de savoir quel enregistrement modifier
        $id = $_GET['id'];

        // verif si le film existe bien
        $sql = "SELECT id FROM users WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindvalue(':id', $id,PDO::PARAM_INT);
        $query->execute();
        $user = $query->fetch();

        if(!empty($user)) {
          //requête pour compter le nombre de films dans la table
          $sql = "DELETE FROM users WHERE id = :id";
          $query = $pdo->prepare($sql);
          $query->bindvalue(':id', $id,PDO::PARAM_INT);
          $query->execute();
        }
}
// location redirection
header('location: index.php');
