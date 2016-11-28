<?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>

<?php if(!empty($_GET['slug'])){

  $slug = $_GET['slug'];
  $sql = "SELECT *  FROM movies_full WHERE slug = '$slug'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $posters = $query->fetchAll(); ?>

<?php include 'include/header.php';


  foreach ($posters as $poster ) {
    echo '<div class="films"><img src="posters/'. $poster['id'] .'.jpg" alt="'. $poster['title'] .'"/></div>';
    foreach ($poster as $details => $value ) {
     echo '<p class="description">'.$details.' : '.$value.'</p>';

    }
  echo '<button type="button" name="button_a_voir" id="button_a_voir">A voir</button>';
  }

}




 include 'include/footer.php';?>
