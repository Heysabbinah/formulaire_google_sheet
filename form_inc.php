
<!--  HTML FORM -------------------------------------------->
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

  <button id="reset" name="reset" type="submitcancel" value="Effacer" onclick="location.href='http://localhost/reportmission/newform.php'">Annuler</button>
  <button id="submitedit" name="submit" type="submitedit">Envoyer</button>

  <?php } else { ?>

  <button id="submit" name="submit" type="submitnew" data-submit="...Sending">Envoyer</button>

  <?php } ?>

<!-- fin 1er if -->

</fieldset>
</form>
</div><!-- fin div container -->
