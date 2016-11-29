<?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>
<?php include 'include/header.php'; ?>
<?php if(!empty($_GET['slug'])){





  $slug = $_GET['slug'];
  $sql = "SELECT *  FROM movies_full WHERE slug = '$slug'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $posters = $query->fetch();

?>


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
          <?php if(!empty($movie_note)){?>

            <div style="font-size:3rem;"><b><?=$movie_note?></b></div>
          <?php }else{?>

          <form class="" id="movie_note" action="" method="post">
          <label for="">Notez ce film/100</label>
          <input type="number" name="note" value="">
          <input type="hidden" name="movie" value="<?= $id_movie; ?>" />
          <span id="error_note"></span>
          <input type="submit"  name="submit" value="Noter">
          </form>
        <?php }



          if(!empty($_POST['submit_a_voir'])){

            $sql = "INSERT INTO movies_user_note (id_movie, id_user, created_at, status) VALUES (:id_movie, :id_user, NOW(), '2')";
            $query = $pdo->prepare($sql);
            $query->bindvalue(':id_movie', $id_movie,PDO::PARAM_INT);
            $query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
            $query->execute();
          } ?>
          <form action="" method="post">
          <input class="submit_a_voir" type="submit" name="submit_a_voir" value="Film à voir absolument!">
          </form>
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

    // echo $current_film = $posters['id'];


?>




 <?php include 'include/footer.php';?>
