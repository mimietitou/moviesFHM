 <?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>
<?php
// Sous la soumission des différents filtres
if(!empty($_GET['categorySubmit'])){
  // on récupère les données choisis par l'utilisateur
  // si le champs n'est pas rempli, on lui donne une valeur vide pour éviter les erreurs
  if(!empty($_GET['cat'])){
    $categories = $_GET['cat'];
  } else {
    $categories = "";
  }

  if(!empty($_GET['years'])){
    $years = $_GET['years'];
  } else {
    $years = "";
  }

  if(!empty($_GET['popularity'])){
    $popularity = $_GET['popularity'];
  } else {
    $popularity = "";
  }
  if(!empty($_GET['search'])){
    $search = trim(strip_tags($_GET['search']));
  } else {
    $search = "";
  }
  // on crée une varible vide qu'on va nourrir en concaténant
  $and = "";
  if(!empty($search)){
    $nbMots = substr($search, 0);
    $decoupe = explode(' ', $nbMots);
    // on va chercher le premier mot saisit par l'utilisateur  dans les colonne title, cast ou directors
    $and = ' AND title LIKE "%'.$decoupe[0].'%" OR cast LIKE "%'.$decoupe[0].'%" OR directors LIKE "%'.$decoupe[0].'%"';
    if(count($decoupe >1)){
      // si l'utilisateur a entré plusieurs mots on va aussi les comparer  $and
      for ($i=1; $i < count($decoupe) ; $i++) {
        $and .= 'AND title LIKE"%'.$decoupe[$i].'%" OR cast LIKE "%'.$decoupe[$i].'%" OR directors LIKE "%'.$decoupe[$i].'%"';
      }
    }
  }
  if(!empty ($categories)){
    $and .= " AND genres LIKE '%". $categories[0] . "%' ";
    for($i = 1 ; $i < count($categories); $i++)
      $and .= " OR genres LIKE '%". $categories[$i] . "%' ";
  }

  if(!empty($years)){
    $year = explode('-', $years);
    $and .= ' AND year >= ' .$year[0].' AND year <= ' .$year[1].' ';
  }
  if(!empty($popularity)){
    $popu = explode('-', $popularity);
    $and .= ' AND popularity >= ' .$popu[0].' AND popularity <= ' .$popu[1].' ';
  }



  //  la variable $and vaudra les choix de l'lutilisateur
  $sql = "SELECT * FROM movies_full WHERE 1 = 1 $and ORDER BY RAND() LIMIT 5";
  $query = $pdo->prepare($sql);
    if(!empty($search)){
      $query->bindValue(':search','%'.$search.'%',PDO::PARAM_STR);
    }
  $query->execute();
  $posters = $query->fetchAll();
  print_r($posters);



} else {
  // par défaut on affiche des films au hasard
  $sql = "SELECT *  FROM movies_full ORDER BY RAND() LIMIT 20";
  $query = $pdo->prepare($sql);
  $query->execute();
  $posters = $query->fetchAll();
  include 'include/header.php';
}





?>



<button type="button" id="filtres" name="filtres">Filtres</button><br>

<div class="div_filter" style="display:none;" id="div_form">
  <form action="index.php" name="category" method="GET">
    <input type="search" name="search" placeholder="Votre recherche">
    <div class="div_category filter_detail">
      <button type="button"  id="select-all">Sélectionner tout</button><br>
      <!-- <input type="checkbox" id="select-all"> All<br> -->
      <input type="checkbox" name="cat[]" value="Fantasy"> Fantasy<br>
      <input type="checkbox" name="cat[]" value="Drama"> Drama<br>
      <input type="checkbox" name="cat[]" value="Romance"> Romance<br>
      <input type="checkbox" name="cat[]" value="Thriller"> Thriller<br>
      <input type="checkbox" name="cat[]" value="Action"> Action<br>
      <input type="checkbox" name="cat[]" value="Comedy"> Comedy<br>
      <input type="checkbox" name="cat[]" value="Family"> Family<br>
      <input type="checkbox" name="cat[]" value="Sci-Fi"> Sci-Fi<br>
      <input type="checkbox" name="cat[]" value="Horror"> Horror<br>
      <input type="checkbox" name="cat[]" value="Mystery"> Mystery<br>
      <input type="checkbox" name="cat[]" value="Animation"> Animation<br>
      <input type="checkbox" name="cat[]" value="Adventure"> Adventure<br>
      <input type="checkbox" name="cat[]" value="Crime"> Crime<br>

    </div>


    <div class="div_years filter_detail">
     <select action="index.php" name="years">

       <option value="">Toutes les années</option><br>
       <option value="1900-1930"> avant 1930</option><br>
       <option value="1930-1940"> 1930-1940</option><br>
       <option value="1940-1950"> 1940-1950</option><br>
       <option value="1950-1960"> 1950-1960</option><br>
       <option value="1960-1970"> 1960-1970</option><br>
       <option value="1970-1980"> 1970-1980</option><br>
       <option value="1980-1990"> 1980-1990</option><br>
       <option value="1990-2000"> 1990-2000</option><br>
       <option value="2000-2010"> 2000-2010</option><br>
       <option value="2010-3000 "> après 2010</option><br>
     </select>
   </div>

    <div class="div_popularity filter_detail">
      <select action="index.php" name="popularity">
        <option value="">Toutes popularités</option><br>
        <option value="80-100 "> 80-100</option><br>
        <option value="60-80"> 60-80</option><br>
        <option value="40-60"> 40-60</option><br>
        <option value="20-40"> 20-40</option><br>
        <option value="0-20"> 0-20</option><br>
      </select>
    </div>
    <input type="submit" name="categorySubmit" value="categorySubmit">
  </form>
</div>
<?php
foreach ($posters as $poster){
  echo '<a href="./details.php?slug='.$poster['slug'].'"><img src="posters/'.$poster['id'].'.jpg"></a>';
}?>
<a href="index.php"><button type="button" name="button">Plus de films</button></a>
 <?php include ('include/footer.php');?>
