<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>
<?php
$sql = "SELECT count('id') FROM movies_full";
$query = $pdo->prepare($sql);
$query->execute();
$nbFilms = $query->fetchColumn();

$sql = "SELECT count('id') FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$nbUsers = $query->fetchColumn();


?>
<?php include('include/header_admin.php'); ?>
<!-- Statistiques -->
<table>
  <tr>
    <th>Nombres de films</th>
    <th>Nombres d'utilisateurs</th>
  </tr>
  <tr>
    <td><?php echo $nbFilms; ?></td>
    <td><?php echo $nbUsers; ?></td>
  </tr>
</table>



<!-- Consultation/Ajout/Modification/Supression de films -->



<!-- Consultation/Modification/Supression d'utilisateurs -->
