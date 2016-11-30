<?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>
<?php include 'include/header.php';

if(!is_logged_user()){
  header('Location: connexion.php' );
}
$id_user = $_SESSION['user']['id'];

$sql = "SELECT *
        FROM movies_full
        LEFT JOIN movies_user_note
        ON movies_user_note.id_movie = movies_full.id
        WHERE status = 3 AND movies_user_note.id_user = :id_user
";
$query = $pdo->prepare($sql);
$query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
$query->execute();
$results = $query->fetchAll();
print_r($results['id']);
















include 'include/footer.php';
