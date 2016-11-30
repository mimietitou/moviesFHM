<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>
<?php
//requête pour compter le nombre d'utilisateurs dans la table
$sql = "SELECT count('id') FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$nb_users = $query->fetchColumn();

//requête pour compter le nombre de films dans la table
$sql = "SELECT COUNT(id) FROM movies_full";
$query = $pdo->prepare($sql);
$query->execute();
$nb_films = $query->fetchColumn();
?>
<?php include('include/header_admin.php'); ?>
<!-- Statistiques -->
<table class="statistique">
  <tr>
    <th class="titre">Films</th>
    <th class="titre">Utilisateurs</th>
  </tr>
  <tr>
    <td><?php echo $nb_films; ?></td>
    <td><?php echo $nb_users; ?></td>
  </tr>
</table>
