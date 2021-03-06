<?php
if(!isset($_SESSION)) {
     session_start();
} ?>
<?php function recupImage($poster)
  { ?>

    <div class="films"><a href="./details.php?id=<?php echo $poster['id']; ?>"><img src="./posters/<?php echo $poster['id'];?>.jpg" alt="<?php echo $poster['title']; ?>" /></a></div>

<?php  }?>

<?php
// Fonction encodage JSON (Michele)
function showJson($data)
{
  header("Content-type: application/json");
  $json = json_encode($data,JSON_PRETTY_PRINT);
  if($json) {
    die($json);
  }
  else {
  die("error in json encoding");
  }
}
// Fonction pour encoder le mot de passe (Michele)
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
// Fonction qui permet de vérifier si un utilisateur est logué (Michele)
function is_logged_user() {
  if (!empty($_SESSION['user']['pseudo'])&&!empty($_SESSION['user']['id'])&& !empty($_SESSION['user']['status'])&&!empty($_SESSION['user']['ip'])) {
    if($_SESSION['user']['ip'] === $_SERVER['REMOTE_ADDR'] ) {
      return true;
    }
  }
  return false;
}
// Fonction qui permet de vérifier si un admin est logué
function is_logged_admin() {
  if(!empty($_SESSION['user']['pseudo']) && !empty($_SESSION['user']['id']) && !empty($_SESSION['user']['status']) && !empty($_SESSION['user']['ip'])) {
    if($_SESSION['user']['ip'] === $_SERVER['REMOTE_ADDR'] && $_SESSION['user']['status'] === 'admin') {
      return true;
    }
  }
  return false ;
}
// Fonction pagination
function paginationFilms($page,$films_page,$nb_films) {
		echo '<div class="pagination">';
		if ($page > 1){
        echo '<a href="dashboard.php?page=' . ($page - 1) . '" class="btn btn-primary">Précédent</a>';
    }
 	//n'affiche le lien vers la page suivante que s'il y en a une
    if ($page*$films_page < $nb_films) {
        echo '<a href="dashboard.php?page=' . ($page + 1) . '" class="btn btn-primary">Suivant</a>';
    }
    echo '</div>';
}
// Fonction pagination
function paginationUsers($page,$users_page,$nb_users) {
		echo '<div class="pagination">';
		if ($page > 1){
        echo '<a href="utilisateurs.php?page=' . ($page - 1) . '" class="btn btn-primary">Précédent</a>';
    }
 	//n'affiche le lien vers la page suivante que s'il y en a une
    if ($page*$users_page < $nb_users) {
        echo '<a href="utilisateurs.php?page=' . ($page + 1) . '" class="btn btn-primary">Suivant</a>';
    }
    echo '</div>';
}
// Fonction sécurité GET
function secu_get($get_name)
{
  return trim(strip_tags($_GET[$get_name]));
}
