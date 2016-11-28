<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>

<?php include('include/header.php'); ?>
  <!-- FORMULAIRE d'inscription -->
<div id="inscriptiondone"></div>
<div class="container responsive">
  <div class="row">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Creer un nouveau compte</h4>
      </div>

      <form id="inscription" action="inscription_ajax.php" method="post">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="pseudo">Pseudo*</label><br><br>
                <input class="parent" type="text" name="pseudo" value=""><br>
                <span class="help-block" id="error_pseudo"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email*</label><br><br>
                <input class="enfant" type="email" name="email" value=""><br>
                <span class="help-block" id="error_email"></span><br>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="password">Password*</label><br><br>
                <input class="enfant" type="password" name="password" value=""><br>
                <span class="help-block" id="error_password"></span><br>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="repeatpassword">Repeat password*</label><br><br>
                <input class="enfant" type="password" name="repeatpassword" value=""><br>
                <span class="help-block" id="error_repeatpassword"></span><br>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="isEmpty" value="">
          <button type="submit" name="submit" value="Je m'inscris" class="btn btn-success btn-icon"><i class="fa fa-check"></i> Creer mon compte</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include('include/footer.php');?>
