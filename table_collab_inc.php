
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
