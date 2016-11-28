<?php

try {
       $pdo = new PDO('mysql:host=192.168.1.20;dbname=movies_full', "Webforce3", "webforce3", array(
           PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
           PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
       ));

   }
   catch (PDOException $e) {
       echo 'Erreur de connexion : ' . $e->getMessage();
   }
?>
