<?php
  function show_debug(){
    print_r($_SESSION);
?>


<!-- autre forme show debug -->

<?php
function html_show_debug(){
  ?>

<div class="container">
  <form>
    <fieldset>
    <textarea name="code_source" rows="20" cols="150">

      <?php
      echo ' ';
      echo ' ';
      print_r($_SESSION['values_collaborateurs'][$_GET['id_record']]['nom-collaborateur']);

      ?>

    </textarea>
    </fieldset>
  </form>
</div>

<?php
}
}
?>
