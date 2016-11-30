<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>
<?php

//nombre de films par page
$films_page = 100;
//numéro de page
$page = 1;
//offset par défaut
$limit = 0;

//requête pour compter le nombre de films dans la table
$sql = "SELECT COUNT(id) FROM movies_full";
$query = $pdo->prepare($sql);
$query->execute();
$nb_films = $query->fetchColumn();


if(!empty($_GET['page']) && is_numeric($_GET['page'])) {
  // sécurité XXS
  $page = secu_get('page');
  // Limite de l'offset
  $limit = ($page - 1) * $films_page;
  }
  // Nombre de page
  $nb_page = ceil($nb_films/$films_page);

// on récupère nos données, en incluant les paramètres d'offset pour la pagination
$sql = "SELECT * FROM movies_full
        LIMIT $limit,$films_page";
$query = $pdo->prepare($sql);
$query->execute();
$films = $query->fetchAll();
?>

<?php include('include/header_admin.php'); ?>

<!-- Pagination -->
<?php
	        // fonction affichage de la pagination
	        paginationFilms($page,$films_page,$nb_films);
	    ?>


<!-- Consultation/Ajout/Modification/Supression de films -->
<table class="consultation">
  <thead>
    <tr class="titre">
      <th class="titre">id</th>
      <th class="titre">title</th>
      <th class="titre">year</th>
      <th class="titre">rating</th>
      <th class="titre">actions</th>
    </tr>
  </thead>
  <?php foreach($films as $film) { ?>
  <tbody>
    <tr>
      <td><?php echo $film['id']; ?></td>
      <td><?php echo $film['title']; ?></td>
      <td><?php echo $film['year']; ?></td>
      <td><?php echo $film['rating']; ?></td>
      <td>
        <a class="back" href="./details.php?slug=<?php echo $film['slug']?>"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></a>
        <a class="back" href="./modification_users.php?id=<?php echo $film['id']?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
        <a class="back" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');" class="suppression" href="./suppression_films.php?id=<?php echo $film['id']?>"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
      </td>
    </tr>
  </tbody>
  <?php } ?>
</table>

<!-- Consultation/Modification/Supression d'utilisateurs -->
