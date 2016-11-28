<?php
session_start();
include('include/pdo.php');
include('include/functions.php');

include('include/header.php');




 ?>
<form class="" action="" method="POST">
  <div class="movie_note"></div>
 <input type="number" name="note" value="">
 <span id="error_note"></span>
 <input type="submit" name="noteDubmit" value="">
</form>
<?php include('include/footer.php') ?>
