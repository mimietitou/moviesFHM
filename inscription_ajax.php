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
  $email = trim(strip_tags($_POST['email']));
  $password = trim(strip_tags($_POST['password']));
  $repeatpassword = trim(strip_tags($_POST['repeatpassword']));

  // Vérification des champs
  if(!empty($pseudo)){
    // vérification de la longueur du pseudo
    if( strlen($pseudo) < 4){
      $error['pseudo'] = 'Votre pseudo est trop court';
    }elseif( strlen($pseudo) > 20){
      $error['pseudo'] = 'Votre pseudo est trop long';
    } else {
      // si la longueur est correcte, on vérifie que le pseudo n'existe pas déjà
      $sql = "SELECT id FROM users WHERE pseudo = :pseudo";
      $query = $pdo->prepare($sql);
      $query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
      $query->execute();
      $result = $query->fetch();
      // si le résultat de la requete n'est pas vide, le pseudo existe
      if(!empty($result)){
        $error['pseudo'] = "Votre pseudo est déjà utilisé";
      }
    }
  }else{
    // si le champ pseudo est vide, message d'erreur
    $error['pseudo'] = 'Vous n\'avez pas rempli ce champs';
  }

  if(!empty($email)){
    // vérification de l'adresse email valide
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error['email'] = 'Ceci n\'est pas une adresse mail';
    }else {
      // si le mail est valide, on vérifie qu'il n'existe pas déjà
      $sql = "SELECT id FROM users WHERE email = :email";
      $query = $pdo->prepare($sql);
      $query->bindValue(':email',$email,PDO::PARAM_STR);
      $query->execute();
      $result = $query->fetch();
      if(!empty($result)){
        // si le résultat de la requète n'est pas vide, l'email existe
        $error['email'] = "Votre email est déjà utilisé";
      }
    }
  }else{
    // si le champ email est vide, message d'erreur
    $error['email'] = 'Vous n\'avez pas rempli ce champs';
  }

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

  if(!empty($repeatpassword)){
    if($repeatpassword != $password){
      $error['repeatpassword'] = 'Vous n\'avez pas saisi le bon password';
    }
  }else{
    $error['repeatpassword'] = 'Vous n\'avez pas rempli ce champs';
  }
 // si pas d'erreur
  if(count($error) == 0){
    // on hash le password en BDD
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  //  et on génère un token pour récupérer le mot de passe
  $token = generateRandomString(50);
    // on enregistre les données du formulaire en BDD
    $sql = "INSERT INTO users VALUES('', :pseudo, :email, :password, :token, NOW(), 'user', 'user')";
    $query = $pdo->prepare($sql);
    // on sécurise sa base de données
    $query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
    $query->bindValue(':email',$email,PDO::PARAM_STR);
    $query->bindValue(':password',$hashedPassword,PDO::PARAM_STR);
    $query->bindValue(':token',$token,PDO::PARAM_STR);
    $query->execute();
    $success = true;
    // header('location: connexion.php');
  }
  // Encodage Json
  $response = array(
    'error'  => $error,
    'success'  => $success
  );

  showJson($response);
