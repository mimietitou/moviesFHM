<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
include('include/header.php');
?>
<?php
//fonction pour quitter la session utilisateur -->
session_destroy();
// redirection vers la page index.php
header('location:index.php');


include('include/footer.php');
 ?>
