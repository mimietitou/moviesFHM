<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>
<?php
// Gestion des erreurs
$error = array();
$success = false;
//sécurité ++++ Faille XSS
$pseudo = trim(strip_tags($_POST['pseudo']));
$password = trim(strip_tags($_POST['password']));

if(!empty($password)){
    // vérification de la longueur du password
    if(strlen($password) < 6){
      $error['password'] = 'Votre password est trop court';
    }
    if(strlen($password) > 40){
      $error['password'] = 'Votre password est trop long';
    }
  }else{
    // si le champ password est vide, message d'erreur
    $error['password'] = 'Vous n\'avez pas rempli ce champs';
  }
//  on va chercher le mail ou le pseudo dans la BDD
$sql = "SELECT * FROM users WHERE pseudo = :pseudo OR email = :pseudo";
$query = $pdo->prepare($sql);
$query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
$query->execute();
$user = $query->fetch();
// si le résultat n'est pas vide
if(!empty($user)){
  //  on vérifie que le password est associé au pseudo
  if (!password_verify($password, $user['password'])) {
    $error['pseudo'] = 'Le mot de passe est invalide.';
  } else {
    if(count($error) == 0){
      // si c'est le cas on ouvre une session utilisateur
      $success = true;
      $_SESSION['user'] = array(
        'pseudo'  => $user['pseudo'],
        'id'      => $user['id'],
        'role'    => $user['role'],
        // on vérifie l'ip de l'utilisateur
        'ip'      => $_SERVER['REMOTE_ADDR']
      );
    }
  }
} else {
  //  et si le résultat est vide message le pseudo ou email n'existe pas en BDD
  $error['pseudo'] = 'Votre pseudo et ou email n\'existe pas dans notre BDD';
}

 // Encodage Json
 $response = array(
   'error'  => $error,
   'success'  => $success
 );

  showJson($response);
 ?>
