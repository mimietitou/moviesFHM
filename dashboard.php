<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>
<?php

//requête pour compter le nombre de films dans la table
$sql = "SELECT COUNT(id) FROM movies_full";
$query = $pdo->prepare($sql);
$query->execute();
$nbFilms = $query->fetchColumn();

//requête pour compter le nombre d'utiolisateurs dans la table
$sql = "SELECT count('id') FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$nbUsers = $query->fetchColumn();

//nombre de films par page
$num = 100;
//numéro de page par defaut
$page = 1;
//offset par défaut
$offset = 0;
//écrasée par celui de l'URL si get['page'] n'est pas vide
// index.php?page=xxxx
if (!empty($_GET['page'])){
    $page = $_GET['page'];
    $offset = ($page - 1) * $num;
}
// Nombre de page
$offset = ceil($nbFilms/$num);
// on récupère nos données, pour affichage plus bas
    //inclus les paramètres d'offset pour la pagination
$sql = "SELECT * FROM movies_full
        LIMIT $offset,$num";
$query = $pdo->prepare($sql);
$query->execute();
$films = $query->fetchAll();
?>


<?php include('include/header_admin.php'); ?>

<?php// fonction affichage de la pagination
paginationIdea($page,$num,$films);?>

<!-- Statistiques -->
<table class="statistique">
  <tr class="titre">
    <th>Nb de films</th>
    <th>Nb d'utilisateurs</th>
  </tr>
  <tr>
    <td><?php echo $nbFilms; ?></td>
    <td><?php echo $nbUsers; ?></td>
  </tr>
</table>
<br><br>
<!-- Consultation/Ajout/Modification/Supression de films -->
<table class="consultation">
  <thead>
    <tr class="titre">
      <th>id</th>
      <th>title</th>
      <th>year</th>
      <th>rating</th>
      <th>actions</th>
    </tr>
  </thead>
  <?php foreach($films as $film) {?>
  <tbody>
    <tr>
      <td><?php echo $film['id']; ?></td>
      <td><?php echo $film['title']; ?></td>
      <td><?php echo $film['year']; ?></td>
      <td><?php echo $film['rating']; ?></td>
      <td>
        <li class="back"><a href="./details.php?slug=<?php echo $film['slug']?>"><i class="fa fa-eye fa-lg" aria-hidden="true">Voir sur le site</i></a></li>
        <li class="back"><a href="#"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true">Modifier</i></a></li>
        <li class="back"><a href="#"><i class="fa fa-trash fa-lg" aria-hidden="true">Effacer</i></a></li>
      </td>
    </tr>
  </tbody>
  <?php }; ?>
</table>

<!-- Consultation/Modification/Supression d'utilisateurs -->
