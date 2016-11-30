<?php
include 'include/pdo.php';
include 'include/functions.php';
?>


<?php
$id_user = $_SESSION['user']['id'];

$sql = "SELECT movies_user_note.id_movie AS user_movie ,
movies_user_note.id_user ,
movies_full.title AS full_title ,
movies_full.plot AS full_plot,
movies_full.slug AS full_slug
FROM movies_user_note
LEFT JOIN movies_full
ON movies_user_note.id_movie = movies_full.id
WHERE status = 1 AND movies_user_note.id_user = :id_user";
$query = $pdo->prepare($sql);
$query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
$query->execute();
$selecteds = $query->fetchAll();

?>

<?php include 'include/header.php'; ?>
<?php




foreach($selecteds as $selected){
  $selected_id_movie = $selected['user_movie'];
  $selected_title_movie = $selected['full_title'];
  $selected_plot_movie = $selected['full_plot'];
  $selected_slug_movie = $selected['full_slug'];  ?>


  <div class="container container_films_thumb clearfix">
  <a href="details.php?slug=<?php echo $selected_slug_movie ?>"><img class="film_thumb" src="posters/<?php echo $selected_id_movie ?>.jpg" alt="affiche de <?php echo $selected_title_movie ?>"></a>
    <h4 class="description_thumb"><?php echo $selected_title_movie ?>:</h4>
    <p class="description_thumb"><?php echo $selected_plot_movie ?></p>

  </div>

  <?php } ?>





 <?php include 'include/footer.php';?>
