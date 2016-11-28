<?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>
<?php include 'include/header.php'; ?>
<?php if(!empty($_GET['slug'])){

  $slug = $_GET['slug'];
  $sql = "SELECT *  FROM movies_full WHERE slug = '$slug'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $posters = $query->fetch();



    echo '<div class="films"><img src="posters/'. $posters['id'] .'.jpg" alt="'. $posters['title'] .'"/></div>';
    foreach ($posters as $poster => $value ) {
      echo '<p class="description">'.$poster.' : '.$value.'</p>';
    };

    $id_movie = $posters['id'];
    $id_user = $_SESSION['user']['id'];


  foreach ($posters as $poster ) {?>
    <div class="films"><img src="posters/<?php echo $poster['id'];?>.jpg" alt="<?php echo $poster['title']; ?>"/>
      <?php if(is_logged_user()){?>
          <div id="show_note"></div><?php } ?>
            <form class="" id="movie_note" action="" method="post">
              <label for="">Notez ce film/100</label>
              <input type="number" name="note" value="">
              <span id="error_note"></span>
              <input type="submit"  name="submit" value="Noter">
            </form>
        </div>
        <?php
    foreach ($poster as $details => $value ) {
     echo '<p class="description">'.$details.' : '.$value.'</p>';

    if(!empty($_POST['submit'])){

      $sql = "INSERT INTO movies_user_note (id_movie, id_user, created_at, status) VALUES (:id_movie, :id_user, NOW(), 'a_voir')";
      $query = $pdo->prepare($sql);
      $query->bindvalue(':id_movie', $id_movie,PDO::PARAM_INT);
      $query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
      $query->execute();


    }

    echo $current_film = $posters['id'];

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



  ?>

  <form action="" method="post">
    <input type="submit" name="submit" value="Film à voir absolument!">
  </form>


  <?php



}?>




 <?php include 'include/footer.php';?>
