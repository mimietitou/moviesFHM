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
  $posters = $query->fetch();

?>

<!-- affichage des données du film -->
    <div class="container container_films_details">
      <img class="film_img" src="posters/<?php echo $posters['id'] ?>.jpg" alt="<?php echo $posters['title'] ?>">
      <?php
    foreach ($posters as $poster => $value ) {?>
      <p class="description"><span class="title_desc"><?php echo $poster ?>: </span><?php echo $value ?></p>
    <?php }; ?>
    </div>

<?php



      if(is_logged_user()){
        $id_movie = $posters['id'];
        $id_user = $_SESSION['user']['id'];
        // on va chercher la note entrée par l'utilisateur pour ce film
        $sql = "SELECT * FROM movies_user_note WHERE id_user = $id_user AND id_movie = $id_movie";
        $query = $pdo->prepare($sql);
        $query->execute();
        $user_movie_info = $query->fetch();
        $movie_note = $user_movie_info['note'];
        ?>
        <div class="container">
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
            WHERE id_movie = :id_movie AND id_user = :id_user";
            $query = $pdo->prepare($sql);
            $query->bindvalue(':id_movie', $id_movie,PDO::PARAM_INT);
            $query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
            $query->execute();
          }
// recherche des films déja présent dans film_a_voir pour adapter bouton A VOIR ou DEJA VU
          $sql = "SELECT *
          FROM movies_user_note
          WHERE id_user = :id_user AND id_movie = :id_movie  && status = 2";
          $query = $pdo->prepare($sql);
          $query->bindvalue(':id_movie', $id_movie,PDO::PARAM_STR);
          $query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
          $query->execute();
          $in_selected = $query->fetchAll();
// affichage des boutons en fonction A VOIR ou DEJA VU
          if(!empty($in_selected)){ ?>
            <form action="" method="post">
            <input class="submit_deja_vu" type="submit" name="submit_deja_vu" value="Déjà vu">
            </form>
          <?php }else{
// =============================HER AJOUT 20191129======================= -->
        if(!empty($movie_note)){?>

         <div style="font-size:3rem;">
          <?php if($movie_note >= 0 && $movie_note < 20 ){
              echo '<i class="fa fa-star-o" aria-hidden="true"><b><?=$movie_note?></b></i>';
          } elseif($movie_note >= 20 && $movie_note < 40 ){
              echo '<i class="fa fa-star-o" aria-hidden="true"><b><?=$movie_note?></b></i><i class="fa fa-star-o" aria-hidden="true"></i>';
          }  ?>
         </div>
        <?php }else{?>

        <form class="" id="movie_note" action="" method="post">
        <label for="">Notez ce film/100</label>
        <input type="number" name="note" value="">
        <input type="hidden" name="movie" value="<?= $id_movie; ?>" />
        <span id="error_note"></span>
        <input type="submit"  name="submit" value="Noter">
        </form>
          <form action="" id="aVoir" method="post">
          <input class="submit_a_voir" type="submit" name="submit_a_voir" value="Film à voir absolument!">
          </form>
          <?php }
         } ?>
          <a href="film_a_voir.php"><button type="button" name="ma_selection" class="ma_selection">Ma selection</button></a>
        </div>
        <?php
        $sql = "SELECT * FROM movies_user_note WHERE status = 'a_voir' && id_user = :id_user";
        $query = $pdo->prepare($sql);
        $query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
        $query->execute();
        $selecteds = $query->fetchAll();

        foreach($selecteds as $selected){
          if ($posters['id'] = $selected['id_movie']){
            echo $selected['id_movie'];
          }
        }
      }
}


?>




 <?php include 'include/footer.php';?>
