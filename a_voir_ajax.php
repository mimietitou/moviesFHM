<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
// si l'utilisateur est connecté on lui propose de noter le film
// $id_movies = $poster['id'];
$id_user = $_SESSION['user']['id'];
$success = false;

if(!empty($_POST['a_voir'])){
  $id_movie = $_POST['a_voir'];
  $sql = "INSERT INTO movies_user_note (id_movie, id_user, created_at, status) VALUES (:id_movie, :id_user, NOW(), 1)";
  $query = $pdo->prepare($sql);
  $query->bindvalue(':id_movie', $id_movie,PDO::PARAM_INT);
  $query->bindvalue(':id_user',$id_user,PDO::PARAM_INT);
  $query->execute();
  $success = true;
}


$sql = "SELECT slug FROM movies_full WHERE id = $id_movie";
$query = $pdo->prepare($sql);
$query->execute();
$r = $query->fetch();
//////////////////////////////////////////////////////////////////////////////////
//création d'un tableau contenant la valuer de $success et les erreurs des champs
/////////////////////////////////////////////////////////////////////////////////
$response = array(
  'success' => $success,
   'slug'   => $r['slug']
);
/////////////////////////////////////////////////////////////////////////
//On renvoit le tableau vers la requête ajax
////////////////////////////////////////////////////////////////////////
showJson($response);
