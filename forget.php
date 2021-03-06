<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

include('include/pdo.php');
include('include/functions.php');

?>
<?php
// Soumission des données du formulaire dans la BDD
if(!empty($_POST['submit'])){
  //sécurité ++++ Faille XSS
  $email = trim(strip_tags($_POST['email']));


  if(!empty($email)) {
    //  on va chercher le mail et le token dans la BDD
    $sql = "SELECT email, token FROM users WHERE email = :email";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email',$email,PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();


    // s'il y a un utilisateur associé à l'email fourni
     if(!empty($user)){
    // on lui envoie un mail avec un lien de renvoi sur la page releasepassword.php

      $emailurl = urlencode($email);
      $html = '';
      $html .= '<a href="http://localhost/moviesFHM-master/releasepassword.php?email=' . $emailurl .'&token=' .  $user['token'] . '">Cliquez ici</a>';

    //envoi du mail
      $mail = new PHPMailer;
      $mail->isMail();

      $mail->setFrom('mragot2@msn.com');
      $mail->addAddress($email);     // Add a recipient
      $mail->Subject = 'Votre nouveau mot de passe';
      $mail->Body    = $html;



      if(!$mail->send()) {
          echo 'Le message n\'a pas été envoyé.';
          echo 'Erreur Mail: ' . $mail->ErrorInfo;
      } else {
          echo 'Le message a bien été envoyé';
          header('location: releasepassword.php');
      }
    } else {
    echo 'Veuillez renseigner un email';
    }
  }
}
include('include/header.php');?>

<!-- // FORMULAIRE soumission d'email pour mot de passe oublié -->
<form  action="" method="post">
  <div class="container responsive">
    <div class="row">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Mot de passe oublié</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Votre Email*</label><br><br>
                <input class="parent" type="email" name="email" value="<?php if(!empty($_POST['email'])) {echo $_POST['email'];} ?>"><br>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" value="soumettre" class="btn btn-success btn-icon"><i class="fa fa-check"></i>Soumettre</button>
        </div>
      </div>
    </div>
  </div>
</form>
<?php include('include/footer.php') ?>
