<?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>

<?php if(!empty($_GET['slug'])){

  $slug = $_GET['slug'];
  $sql = "SELECT *  FROM movies_full WHERE slug = '$slug'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $posters = $query->fetchAll();

  if(!empty())


  ?>

<?php include 'include/header.php';


  foreach ($posters as $poster ) {
    echo '<div class="films"><img src="posters/'. $poster['id'] .'.jpg" alt="'. $poster['title'] .'"/></div>';
    foreach ($poster as $details => $value ) {
     echo '<p class="description">'.$details.' : '.$value.'</p>';

   } ?>
  <form class="" action="index.html" method="post">

  </form>
  <input type="submit" name="film_a_voir" value="Film à voir absolument!" method="post">

  <?php
  }

}?>




 <?php include 'include/footer.php';?>
