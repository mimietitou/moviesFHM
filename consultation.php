<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
?>
<?php
//nombre de films par page
    $num = 100;
    //numéro de page par defaut
    $page = 1;
    //offset par défaut
    $offset = 0;

//requête pour compter le nombre de films dans la table
    $sql = "SELECT COUNT(id) FROM movies_full";
    $query = $pdo->prepare($sql);
    $query->execute();
    $count = $query->fetchColumn();

    //écrasée par celui de l'URL si get['page'] n'est pas vide
    // index.php?page=xxxx
    if (!empty($_GET['page'])){
        $page = $_GET['page'];
        $offset = ($page - 1) * $num;
    }
    // Nombre de page
    $nbredePage = ceil($count/$num);
    // on récupère nos données, pour affichage plus bas
        //inclus les paramètres d'offset pour la pagination
        $sql = "SELECT * FROM movies_full
                LIMIT $offset,$num";
        $query = $pdo->prepare($sql);
        $query->execute();
        $films = $query->fetchAll();
    ?>
<?php include('include/header.php'); ?>

		<?php
	        // fonction affichage de la pagination
	        paginationIdea($page,$num,$count);
	    ?>
  <table>
    <thead>
      <tr>
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
          <i class="fa fa-eye" aria-hidden="true">Voir sur le site</i>
          <i class="fa fa-eye" aria-hidden="true">Voir sur le site</i>
          <i class="fa fa-eye" aria-hidden="true">Voir sur le site</i>

        </td>
      </tr>
    </tbody>
    <?php }; ?>
  </table>
