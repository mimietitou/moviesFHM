<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
// si l'utilisateur est connecté on lui propose de noter le film
$id_movies = $poster['id'];
$id_user = $_SESSION['user']['id'];
$error = array();
$success = false;
if (!empty($_POST['movie_note'])){
  $note = trim(strip_tags($_POST['note']));


  if(!empty($note)){
    if(!is_numeric($note)){
      $error['note']  = 'Ce n\'est pas une note valide';
    } elseif($note > 100) {
      $error['note'] = 'La note maximale est de 100';
    } elseif($note < 0) {
      $error['note'] = 'La note minimale est de 0';
    }elseif (count($error) === 0) {
      $success = true;
      $sql = "INSERT INTO movies_user_note (id_movie, id_user, note, created_at) VALUES(:id_movie, :id_user, :note, NOW())";
      $query = $pdo->prepare($sql);
      $query->bindValue(':id_movie', $id_movies, PDO::PARAM_INT);
      $query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
      $query->bindValue(':note', $note, PDO::PARAM_INT);
      $query->execute();
    }
  } else {
    $error['note'] = 'Vous n\'avez pas inscrit votre note';
  }
}


         //////////////////////////////////////////////////////////////////////////////////
         //création d'un tableau contenant la valuer de $success et les erreurs des champs
         /////////////////////////////////////////////////////////////////////////////////
         $response = array(
           'success' => $success,
           'error' => $error
         );
         /////////////////////////////////////////////////////////////////////////
         //On renvoit le tableau vers la requête ajax
         ////////////////////////////////////////////////////////////////////////
         showJson($response);
