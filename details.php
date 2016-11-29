<?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>
<?php include 'include/header.php'; ?>
<?php if(!empty($_GET['slug'])){

  $slug = $_GET['slug'];
//select des données dans DB pour affichage sur details
  $sql = "SELECT *  FROM movies_full WHERE slug = :slug";
  $query = $pdo->prepare($sql);
  $query->bindvalue(':slug', $slug,PDO::PARAM_STR);
  $query->execute();
  $posters = $query->fetch();?>

<!-- affichage des données du film -->
    <div class="container container_films_details">
      <img class="film_img" src="posters/<?php echo $posters['id'] ?>.jpg" alt="<?php echo $posters['title'] ?>">
      <?php
    foreach ($posters as $poster => $value ) {?>
      <p class="description"><span class="title_desc"><?php echo $poster ?>: </span><?php echo $value ?></p>
    <?php }; ?>
    </div>

<?php
  $id_movie = $posters['id'];
  $id_user = $_SESSION['user']['id'];
  $current_movie = $posters['id'];
// affichage des options user si logged

//affichage du rating
      if(is_logged_user()){?>
        <div class="container">
          <div id="show_note">
            <form class="" id="movie_note" action="" method="post">
              <label for="">Notez ce film/100</label>
              <input type="number" name="note" value="">
              <span id="error_note"></span>
              <input type="submit"  name="submit" value="Noter">
            </form>
          </div>
          <?php
//param bouton A VOIR pour insert dans film_a_voir.php
          if(!empty($_POST['submit_a_voir'])){
            $sql = "INSERT INTO movies_user_note (id_movie, id_user, created_at, status) VALUES (:id_movie, :id_user, NOW(), '2')";
            $query = $pdo->prepare($sql);
            $query->bindvalue(':id_movie', $id_movie,PDO::PARAM_INT);
            $query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
            $query->execute();
          }
//=============================HER AJOUT 20191129=======================
//param bouton DEJA VU pour suppr dans film_a_voir.php
          if(!empty($_POST['submit_deja_vu'])){
            $sql = "UPDATE movies_user_note
            SET status = 1
            WHERE id_movie = :current_movie && id_user = :id_user";
            $query = $pdo->prepare($sql);
            $query->bindvalue(':current_movie', $current_movie,PDO::PARAM_INT);
            $query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
            $query->execute();
          }
// recherche des films déja présent dans film_a_voir pour adapter bouton A VOIR ou DEJA VU
          $sql = "SELECT *
          FROM movies_user_note
          WHERE id_user = :id_user && id_movie = :current_movie  && status = 2";
          $query = $pdo->prepare($sql);
          $query->bindvalue(':current_movie', $current_movie,PDO::PARAM_STR);
          $query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
          $query->execute();
          $in_selected = $query->fetchAll();
// affichage des boutons en fonction A VOIR ou DEJA VU
          if(!empty($in_selected)){ ?>
            <form action="" method="post">
            <input class="submit_deja_vu" type="submit" name="submit_deja_vu" value="Déjà vu">
            </form>
          <?php }else{?>
<!-- =============================HER AJOUT 20191129======================= -->
          <form action="" method="post">
          <input class="submit_a_voir" type="submit" name="submit_a_voir" value="Film à voir absolument!">
          </form>
          <?php } ?>
          <a href="film_a_voir.php"><button type="button" name="ma_selection" class="ma_selection">Ma selection</button></a>
        </div>
        <?php
      }
}


?>




 <?php include 'include/footer.php';?>
