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
