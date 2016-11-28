<?php include 'include/pdo.php' ?>
<?php include 'include/functions.php'; ?>
<?php
if(!empty($_GET['categorySubmit'])){
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

  $and = "";
  if(!empty ($categories)){
    $and .= " AND genres LIKE '%". $categories[0] . "%' ";
    for($i = 1 ; $i < count($categories); $i++)
    $and .= " OR genres LIKE '%". $categories[$i] . "%' ";
  }

  if(!empty($years)){
    $and .= " AND (year " .$years.") ";
    echo $and;
  }

  if(!empty($popularity)){
    $and .= " AND (popularity " .$popularity.") ";
    echo $and;
  }

  if(!empty($search)){
    $and .= " AND title LIKE :search OR  cast LIKE :search  OR  directors LIKE :search ";
  }
  $sql = "SELECT * FROM movies_full WHERE 1 = 1 $and ORDER BY RAND() LIMIT 5";
  $query = $pdo->prepare($sql);
  $query->bindValue(':search','%'.$search.'%',PDO::PARAM_STR);
  $query->execute();
  $posters = $query->fetchAll();
  print_r($posters);



} else {
  $sql = "SELECT *  FROM movies_full ORDER BY RAND() LIMIT 20";
  $query = $pdo->prepare($sql);
  $query->execute();
  $posters = $query->fetchAll();
  include 'include/header.php';
}


foreach ($posters as $poster){
  echo '<a href="./details.php?id='.$poster['id'].'&'.$poster['slug'].'"><img src="posters/'.$poster['id'].'.jpg"></a>';
}



?>

<a href="index.php"><button type="button" name="button">Plus de films</button></a>


<button type="button" id="filtres" name="filtres">Filtres</button>

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
       <option name="year[]" value="" checked></option><br>
       <option name="year[]" value=" < '1930' ">  avant 1930</option><br>
       <option name="year[]" value="BETWEEN '1930' AND '1940' "> 1930-1940</option><br>
       <option name="year[]" value="BETWEEN '1940' AND '1950' "> 1940-1950</option><br>
       <option name="year[]" value="BETWEEN '1950' AND '1960' "> 1950-1960</option><br>
       <option name="year[]" value="BETWEEN '1960' AND '1970' "> 1960-1970</option><br>
       <option name="year[]" value="BETWEEN '1970' AND '1980' "> 1970-1980</option><br>
       <option name="year[]" value="BETWEEN '1980' AND '1990' "> 1980-1990</option><br>
       <option name="year[]" value="BETWEEN '1990' AND '2000' "> 1990-2000</option><br>
       <option name="year[]" value="BETWEEN '2000' AND '2010' "> 2000-2010</option><br>
       <option name="year[]" value="> '2010' "> après 2010</option><br>
     </select>
   </div>

    <div class="div_popularity filter_detail">
      <select action="index.php" name="popularity">
        <option name="1" value="" checked></option><br>
        <option name="2" value="BETWEEN '80' AND '100' "> 80-100</option><br>
        <option name="3" value="BETWEEN '60' AND '80' "> 60-80</option><br>
        <option name="4" value="BETWEEN '40' AND '60' "> 40-60</option><br>
        <option name="5" value="BETWEEN '20' AND '40' "> 20-40</option><br>
        <option name="6" value="BETWEEN '0' AND '20' "> 0-20</option><br>
      </select>
    </div>
    <input type="submit" name="categorySubmit" value="categorySubmit">
  </form>
</div>

<?php include ('include/footer.php');?>
