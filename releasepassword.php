<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>

<?php
//  On vérifie que l'adresse mail et le token de l'url n'est pas vide
if(!empty($_GET['email']) && !empty($_GET['token'])){
  //  On sécurise l'email et le token
  $email = trim(strip_tags($_GET['email']));
  $token = trim(strip_tags($_GET['token']));
  // On décode l'url
  $emailrecup = $_GET['email'];
  $email = urldecode($emailrecup);
  $tokenrecup = $_GET['token'];
  // On sélectionne email et token dans la BDD
  $sql = "SELECT email, token FROM users WHERE email = :email";
  $query = $pdo->prepare($sql);
  $query->bindValue(':email',$email,PDO::PARAM_STR);
  $query->execute();
  $user = $query->fetch();

  if ($email == $user['email'] && $tokenrecup == $user['token']) {
    // si mon formulaire est soumis
    $error = array();
    $success = false;

    if(!empty($_POST['submit'])){
      //sécurité ++++ Faille XSS
      $password = trim(strip_tags($_POST['password']));
      $repeatpassword = trim(strip_tags($_POST['repeatpassword']));

      // Vérification des champs
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
        $sql = "UPDATE users SET password = :password, token = :token WHERE email = :email";
        $query = $pdo->prepare($sql);
        // on sécurise sa base de données
        $query->bindValue(':password',$hashedPassword,PDO::PARAM_STR);
        $query->bindValue(':token',$token,PDO::PARAM_STR);
        $query->bindValue(':email',$email,PDO::PARAM_STR);
        $query->execute();
        $success = true;
        // on redirige sur la page index.html
        header('location: index.php');
      }
    }
  }
  include('include/header.php'); ?>

  <!-- FORMULAIRE de réinitialisation du mot de passe -->
  <form action="" method="POST">
    <label for="password">Password*</label><br><br>
    <input type="text" name="password" value="<?php if(!empty($_POST['password'])){ echo $_POST['password'];} ?>"><br>
    <span class="erreur"><?php if(!empty($error['password'])){ echo $error['password'];} ?></span><br>

    <label for="repeatpassword">Repeat password*</label><br><br>
    <input type="text" name="repeatpassword" value="<?php if(!empty($_POST['repeatpassword'])){ echo $_POST['repeatpassword'];}?>"><br>
    <span class="erreur"><?php if(!empty($error['repeatpassword'])){ echo $error['repeatpassword'];} ?></span><br>

    <input type="submit" name="submit" value="Envoyer">
    <!-- Message d'erreur si l'url n'est pas identique à celle envoyée -->
<?php }else {
  echo 'L\'adresse email n\'existe pas dans notre base de donnée';
} ?>
