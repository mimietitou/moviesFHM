<?php
session_start();
include('include/pdo.php');
include('include/functions.php');
// si l'utilisateur est connecté on lui propose de noter le film
// $id_movies = $poster['id'];
 $id_user = $_SESSION['user']['id'];
$error = array();
$success = false;



if (!empty($_POST['note']) && !empty($_POST['movie'])){
  $note = trim(strip_tags($_POST['note']));
  $id_movie = $_POST['movie'];

  // verfier que le film existe bien
  $sql = "SELECT * FROM movies_full WHERE id = :id";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id', $id_movie, PDO::PARAM_INT);
  $query->execute();
  $movie = $query->fetch();

  if(!empty($movie)){
    // on vérifie si l'utilisateur a entré une note
    if(empty($note)){
      //  on indique a l'utilisateur qu'il n'a pas entré de note avant de soumettre
        $error['note'] = 'Vous n\'avez pas inscrit votre note';
    } else {
      // on vérifie que la note est valide
      if(!is_numeric($note)){
        $error['note']  = 'Ce n\'est pas une note valide';
      } elseif($note > 100) {
        $error['note'] = 'La note maximale est de 100';
      } elseif($note < 0) {
        $error['note'] = 'La note minimale est de 0';
      }elseif (count($error) === 0) {
        // si il n'y a pas d'erreur on l'insère en BDD
        $success = true;

        $sql = "UPDATE movies_user_note
                SET note = :note, status = 3
                WHERE id_movie = :id_movie AND id_user = :id_user";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id_movie', $id_movie, PDO::PARAM_INT);
        $query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $query->bindValue(':note', $note, PDO::PARAM_INT);
        $query->execute();
      }
    }
  }
}
         //////////////////////////////////////////////////////////////////////////////////
         //création d'un tableau contenant la valuer de $success et les erreurs des champs
         /////////////////////////////////////////////////////////////////////////////////
         $response = array(
           'success' => $success,
           'error' => $error,
           'slug'   => $movie['slug']
         );
         /////////////////////////////////////////////////////////////////////////
         //On renvoit le tableau vers la requête ajax
         ////////////////////////////////////////////////////////////////////////
         showJson($response);



         //je vais chercher la note de ce film entrée par l'utilisateur
