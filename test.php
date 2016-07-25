
$values_report = array();
$varchar = null;

foreach($values_collaborateurs as $key_collaborateurs => $row_collaborateurs) {

  $values_report[$key_collaborateurs] = $row_collaborateurs;

  foreach($values_missions as $key_missions => $row_missions) {

      if ($row_missions[1] == $row_collaborateurs[0]) {

        $varchar .= $row_missions[2]." ";

      }

  }

  $values_report[$key_collaborateurs][] = $varchar;
  $varchar = '';

}

//print_r("<pre>\n");
//print_r($values_report);
//print_r("</pre>\n");
//print_r("<br />\n");
