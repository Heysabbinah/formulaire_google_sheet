<?php

//je redeclare une valeur session d'apres values collaborateurs
$_SESSION['values_collaborateurs'] = array(
  'nom-collaborateur'=>$_POST['nom-collaborateur'],
  'email'=>$_POST['email'],
  'fonction'=>$_POST['fonction'],
  'seniorite'=>$_POST['seniorite'],
  );

//ici je recupere les values que je veux seulement de la session values collaborateurs
  $nom_collaborateur = $_SESSION['values_collaborateurs']['nom-collaborateur'];
  $email = $_SESSION['values_collaborateurs']['email'];
  $fonction = $_SESSION['values_collaborateurs']['fonction'];
  $seniorite = $_SESSION['values_collaborateurs']['seniorite'];

// je regroupe tout dans 1 variable de session
  $_SESSION['report']=$_SESSION['values_collaborateurs']['nom-collaborateur']." ".$_SESSION['values_collaborateurs']['email']
  ." ".$_SESSION['values_collaborateurs']['fonction']." ".$_SESSION['values_collaborateurs']['seniorite'];

  ?>
