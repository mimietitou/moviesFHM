<?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>

<?php if(!empty($_GET['slug'])){

  $slug = $_GET['slug'];
  $sql = "SELECT *  FROM movies_full WHERE slug = '$slug'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $posters = $query->fetchAll(); ?>

<?php include 'include/header.php';


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

    }
  echo '<button type="button" name="button_a_voir" id="button_a_voir">A voir</button>';
  }

}


 include 'include/footer.php';
