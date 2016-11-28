<?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>

<?php include 'include/header.php';





if(!empty($_GET['id']) && is_numeric($_GET['id'])){

  $id = $_GET['id'];
  $sql = "SELECT *  FROM movies_full WHERE id = $id ";
  $query = $pdo->prepare($sql);
  $query->execute();
  $posters = $query->fetchAll();

  foreach ($posters as $poster ) {
    echo '<img src="posters/'.$poster['id'].'.jpg">';
    echo '<div class="films"><a href="./details.php?id='. $poster['id'] .'"><img src="/posters/'. $poster['id'] .'.jpg" alt="'. $poster['title'] .'"/></a></div>';
    foreach ($poster as $details => $value ) {
     echo '<p class="description">'.$details.' : '.$value.'</p>';

    }

  }
}






 include 'include/footer.php';?>
