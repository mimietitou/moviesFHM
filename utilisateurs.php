<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>
<?php

//nombre de films par page
$users_page = 100;
//numéro de page
$page = 1;
//offset par défaut
$limit = 0;

//requête pour compter le nombre de films dans la table
$sql = "SELECT COUNT(id) FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$nb_users = $query->fetchColumn();


if(!empty($_GET['page']) && is_numeric($_GET['page'])) {
  // sécurité XXS
  $page = secu_get('page');
  // Limite de l'offset
  $limit = ($page - 1) * $users_page;
  }
  // Nombre de page
  $nb_page = ceil($nb_users/$users_page);

// on récupère nos données, en incluant les paramètres d'offset pour la pagination
$sql = "SELECT * FROM users
        LIMIT $limit,$users_page";
$query = $pdo->prepare($sql);
$query->execute();
$users = $query->fetchAll();
?>

<?php include('include/header_admin.php'); ?>

<!-- Pagination -->
<?php
	        // fonction affichage de la pagination
          paginationUsers($page,$users_page,$nb_users)
	    ?>


<!-- Consultation/Ajout/Modification/Supression de films -->
<table class="consultation">
  <thead>
    <tr class="titre">
      <th class="titre">id</th>
      <th class="titre">pseudo</th>
      <th class="titre">email</th>
      <th class="titre">created_at</th>
      <th class="titre">status</th>
      <th class="titre">actions</th>
    </tr>
  </thead>
  <?php foreach($users as $user) { ?>
  <tbody>
    <tr>
      <td><?php echo $user['id']; ?></td>
      <td><?php echo $user['pseudo']; ?></td>
      <td><?php echo $user['email']; ?></td>
      <td><?php echo $user['createdat']; ?></td>
      <td><?php echo $user['status']; ?></td>
      <td>
        <a class="back" href="./modification_users.php?id=<?php echo $user['id']?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
        <a class="back" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur?');" class="suppression" href="./suppression_users.php?id=<?php echo $user['id']?>"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
      </td>
    </tr>
  </tbody>
  <?php } ?>
</table>
