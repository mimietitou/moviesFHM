<?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>
<?php include 'include/header.php'; ?>
<?php
if(!empty($_GET['slug'])){

// status : a voir = 1
//          vu     = 2
        //  noté   = 3


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
    // on va chercher le status du film
    $sql = "SELECT * FROM movies_user_note WHERE id_user = $id_user AND id_movie = $id_movie";
    $query = $pdo->prepare($sql);
    $query->execute();
    $user_movie_info = $query->fetch();
    $movie_note = $user_movie_info['note'];
    $movie_status = $user_movie_info['status'];
    if(empty($movie_status)){
      ?>
      <form action="" id="aVoir" method="post">
        <input class="submit_a_voir" type="submit" name="submit_a_voir" value="Film à voir absolument!">
      <input  type="hidden" name="a_voir" value="<?= $id_movie; ?>">
      </form>
    ?>
