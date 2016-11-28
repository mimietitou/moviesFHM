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
  // si l'utilisateur est connecté on lui propose de noter le film
  if(is_logged_user()){ ?>
    <label for="">Noter ce film</label>
    <input type="number" name="note" value="">
    <span id="error_note"></span>

<?php   }
} ?>





<?php include 'include/footer.php';?>
