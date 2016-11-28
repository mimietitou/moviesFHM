<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>
<?php include('include/header.php'); ?>

<!-- // FORMULAIRE de connexion -->
<div class="container responsive">
  <div class="row">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Connexion à votre compte</h4>
      </div>
      <form id="connexion" action="connexion_ajax.php" method="post">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="pseudo">Pseudo ou Email*</label><br><br>
                <input class="parent" type="text" name="pseudo" value=""><br>
                <span class="help-block" id="error_pseudo"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="password">Password*</label><br><br>
                <input class="enfant" type="password" name="password" value=""><br>
                <span class="help-block" id="error_password"></span><br>
                <a href="forget.php">Mot de passe oublié</a><br><br>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <label>
  				  <input type="checkbox" name="remember" /> Se souvenir de moi
  			  </label>
          <input type="hidden" name="isEmpty" value="">
          <button type="submit" name="submit" value="connexion" class="btn btn-success btn-icon"><i class="fa fa-check"></i> Connexion</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include('include/footer.php');?>
