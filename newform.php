<?php

  session_start();//demarre une session

  //include_once 'debug.php';
  include_once "./_inc.php";

  putenv('GOOGLE_APPLICATION_CREDENTIALS=json/client_secret.json');//json de collaborateurs

  $idSheet = "1mv-nWlQOevQ9BwCcRVpWcGzlVjtpotPSSb0wyQ4tLlw";//specifie le idsheet ici appel en global ds function
  $range = "Collaborateurs!A2:E"; //ici mettre les ref des colonnes utilisées !! IMPORTANT : nom Feuille travail

  //appelle des fonctions google connexion
  google_connexion_spreadsheet();
?>
<!--//FORM -->
<html>
  <head>
    <meta charset='utf-8'>
    <meta content='IE=edge' http-equiv='X-UA-Compatible'>
    <meta content='width=device-width, initial-scale=1' name='viewport'>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/table.css">
  </head>

<!-- appelle des fonctions -->
<?php

    if (isset($_POST['new_record'])) {

       new_record();

    } elseif (isset($_POST['edit_record'])) {

      edit_record();
}

      google_spreasheet_to_array();

?><!-- fin appelle des fonctions -->

<!--  //////////////////////    HTML FORM     //////////////////////------------>

<div class="container">
    <header><img src="img/logo_rounded.png" alt ="logo_wanagroup" /></header>

    <form id="contact" action="newform.php" method="post"> <!-- action : dans la page ou je suis -->

    <h3><?php if (isset($_GET['show_record'])) echo 'Modifier une ligne'; else echo 'Ajouter une ligne';?></h3>

    <fieldset>
    <input name="nom-collaborateur" type='text' placeholder="nom-collaborateur" tabindex="2" value="<?php if (isset($_GET['show_record'])) echo $_SESSION['values_collaborateurs'][$_GET['id_record']]['nom-collaborateur'];?>" required autofocus />
    </fieldset>
    <fieldset>
    <input name="email" type='text' placeholder="email" tabindex="3" value="<?php if (isset($_GET['show_record'])) echo $_SESSION['values_collaborateurs'][$_GET['id_record']]['email'];?>" required autofocus />
    </fieldset>
    <fieldset>
    <input name="fonction" type='text' placeholder="fonction" tabindex="4" value="<?php if (isset($_GET['show_record'])) echo $_SESSION['values_collaborateurs'][$_GET['id_record']]['fonction'];?>" required autofocus />
    </fieldset>
    <fieldset>
    <input name="seniorite" type='text' placeholder="seniorite" tabindex="5" value="<?php if (isset($_GET['show_record'])) echo $_SESSION['values_collaborateurs'][$_GET['id_record']]['seniorite'];?>" required autofocus />
    </fieldset>
    <fieldset>
    <input name="<?php if (isset($_GET['show_record'])) echo 'edit_record'; else echo 'new_record'; ?>" type="hidden" value="1" />

    <?php

      if (isset($_GET['show_record'])) {

    ?>
      <!-- pour construire le flux xml du edit record pour matcher les indices -->
        <input name="id-collaborateur" type="hidden" value="<?php echo $_SESSION['values_collaborateurs'][$_GET['id_record']]['id-collaborateur'];?>" />
        <input name="etag" type="hidden" value="<?php echo $_SESSION['values_collaborateurs'][$_GET['id_record']]['etag'];?>" />
        <input name="rowId" type="hidden" value="<?php echo $_SESSION['values_collaborateurs'][$_GET['id_record']]['rowId'];?>" />

    <?php
    }
    ?>

    </fieldset>
    <fieldset>
      <!--modif btn pr les scenario -->

      <?php if (isset($_GET['show_record'])) {?>

      <button id="reset" name="reset" type="submitcancel" value="Effacer" onclick="<?php header('location: newform.php')?>">Annuler</button><!--header location redirigie-->
      <button id="submitedit" name="submit" type="submitedit">Envoyer</button>

      <?php } else { ?>

      <button id="submit" name="submit" type="submitnew" data-submit="...Sending">Envoyer</button>

      <?php } ?>

    <!-- fin 1er if -->

    </fieldset>
    </form>
    </div><!-- fin div container -->


<!-- here table collaborateurs -->

<!-- table collaborateur -->
<div class="table-title">
  <h3>nombre de lignes : <?php echo count($values_collaborateurs); ?></h3><!-- appel du count juste echo -->
  </div>

    <table class="table-fill">
    <thead>
    <tr>
    <th class="text-first">id</th>
    <th class="text-second">collaborateurs</th>
    <th class="text-third">email</th>
    <th class="text-fourth">fonction</th>
    <th class="text-fifth">seniorite</th>
    <th class="text-fifth">edit</th>
    </tr>
    </thead>

    <tbody class="table-hover">

<?php
    //here la boucle pour recup les valeurs
    foreach ($values_collaborateurs as $key => $value) {
?>

      <tr>
      <td class="text-firt"><?php echo $value['id-collaborateur']; ?></td><!-- here recup donnees par l'indice -->
      <td class="text-second"><?php echo $value['nom-collaborateur']; ?></td>
      <td class="text-third"><?php echo $value['email']; ?></td>
      <td class="text-fourth"><?php echo $value['fonction']; ?></td>
      <td class="text-fifth"><?php echo $value['seniorite']; ?></td>
      <!--<td class="text-fifth"><?php //echo $value['edit_links']; ?></td>--><!-- effacer le form edit links-->

      <!-- me permet de recuperer l'indice key dans l'url-->
      <td class="text-fifth"><a href="?show_record=1&id_record=<?php echo $key;?>">EDIT</a></td>
      </tr>

<?php

    }
?><!-- fin de la boucle -->


    </tbody>
  </table>
</div><!-- fin div container -->

</body>
</html>
