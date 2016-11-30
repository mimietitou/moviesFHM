<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>
<?php
if(!empty($_GET['slug'])){

//récupération de la variable d'URL,
  //qui va nous permettre de savoir quel enregistrement modifier
  $slug = $_GET['slug']; ;
//requête pour compter le nombre de films dans la table
$sql = "SELECT id FROM movies_full WHERE slug = :slug";
$query = $pdo->prepare($sql);
$query->bindvalue(':slug', $slug,PDO::PARAM_STR);
$query->execute();
$film = $query->fetch();

include('include/header.php'); ?>
  <!-- FORMULAIRE de modification -->

<form id="modification" action="modification.php" method="post">
  <div class="container responsive">
    <div class="row">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modification du film</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="title">title</label><br><br>
                <input class="parent" type="text" name="title" value="<?php echo $film['title']; ?>"><br>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="year">year</label><br><br>
                <input class="enfant" type="year" name="year" value="<?php echo $film['year']; ?>"><br>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" value="modifier" class="btn btn-success btn-icon"><i class="fa fa-check"></i>Modifier</button>
        </div>
      </div>
    </div>
  </div>
</form>
<?php }
 include('include/footer.php');?>
