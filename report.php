<?php
// include your composer dependencies
include_once __DIR__ . '/vendor/autoload.php';
include_once "./base.php";
/**  Create and configure a new client object.
The client object is the primary container for classes and configuration in the library. */
$client = new Google_Client();
$client->setApplicationName("collaborateur-formulaire");
$client->setDeveloperKey("5f465bac19b73f5295907ae062498a34965286b7");//dans google API la ref du projet

/** AUTHENTIFICATION - updgrading file lines (before after)
For service accounts, we now use `setAuthConfig` or `useApplicationDefaultCredentials`*/
putenv('GOOGLE_APPLICATION_CREDENTIALS=json/client_secret.json');//json de collaborateurs
$client->useApplicationDefaultCredentials();

/** COMMENTS */
$client->setApplicationName("collaborateur-formulaire");
$client->setScopes(['https://www.googleapis.com/auth/drive', 'https://spreadsheets.google.com/feeds', 'https://docs.google.com/feeds']);
//ici spreadsheet obligatoire pr fonctionner

$service = new Google_Service_Sheets($client); /** ici add sheets instead of books  */
//COLLABORATEURS
// printf("<h1>TABLEAU COLLABORATEURS</h1>");
$spreadsheetId = "1mv-nWlQOevQ9BwCcRVpWcGzlVjtpotPSSb0wyQ4tLlw"; //id spreadsheet dans URL
$range = "Collaborateurs!A2:E"; //ici mettre les ref des colonnes utilisées !! IMPORTANT : nom Feuille travail
$response = $service->spreadsheets_values->get($spreadsheetId, $range); //ici recolte les values
$values_collaborateurs = $response->getValues(); //ici stock les values

// Access Token is used for Steps 2 and beyond
$tokenArray = $client->fetchAccessTokenWithAssertion();
$accessToken = $tokenArray["access_token"];

        if (count($values_collaborateurs) == 0) { //ici le if data=0 =>> et sinon affiche
        print "Aucuns collaborateurs trouves.<br>\n";
        } else {
          // print "Nom, Email, Profil, Niveau:<br>\n"; //affiche les titres
        foreach ($values_collaborateurs as $row) {
            //code below
          }
        }

//MISSIONS
// printf("<h1>TABLEAU MISSIONS</h1>");//passage a la ligne
$range = "Missions!A2:C"; //ici mettre les ref des colonnes utilisées !! IMPORTANT : nom Feuille travail
$response = $service->spreadsheets_values->get($spreadsheetId, $range); //ici recolte les values
$values_missions = $response->getValues(); //ici stock les values


        if (count($values_missions) == 0) { //ici le if data=0 =>> et sinon affiche
          print "Aucuns collaborateurs trouves.<br>\n";
        } else {
          // print "id-mission, id-collaborateurs, mission, description:<br>\n"; //affiche les titres
          foreach ($values_missions as $row) {
            //code below
          }
        }

          printf("<h1>TABLEAU REPORT</h1>");//passage a la ligne


$report = array();
$job = null; //on met la variable a zero
$i = null;

//On extrait les valeurs dans un nouveau tableau à l'aide d'une boucle :

        foreach ($values_collaborateurs as $key_collab => $row_collab) {

                $report[] = $row_collab; // la valeur de id collab = indice collab

                  $g = 1;
                  $values_job = array();

        foreach($values_missions as $key_mission => $row_mission) {
                //here: si ca match => stock la value 2 : les missions
                        if($row_collab[0] == $row_mission[1]) $values_job[] = $row_mission[2];
                        }

        foreach($values_job as $key_job => $row_job) {
                        if ($g < count($values_job)) $job .= $row_job." - ";
                        else $job .= $row_job;
                          $g++;
                        }

                $report[$key_collab][] = $job;  //$report = table qui contient chq valeur des key collab, et tout ça tu le stock ds $job

$i = null;
$job = null; //stop - remet le cycle job a zero pour recommencer a null

        }
        echo '</table>';

print_r("<pre>\n");
print_r($report);
print_r("<pre>\n");
printf("<br>\n");//passage a la ligne

?>






















              <?php


        //       echo '<table class="table-fill">
        //       <tr>
        //       <th>nom_collaborateurs</th>
        //       <th>ville</th>
        //       <th>fonction</th>
        //       <th>seniorite</th>
        //       <th>mission</th>
        //       </tr>';

             // echo '<tr>';
              //echo '<td>' .$report['nom_collaborateur'].'</td>';
              //echo '<td>' .$report['ville'].'</td>';
              //echo '<td>' .$report['fonction'].'</td>';
              //echo '<td>' .$report['seniorite'].'</td>';
              //echo '<td>' .$report['mission'].'</td>';
              //echo '</tr>';

        //AFFICHE COLLABORATEURS
        // Print columns A and D, which correspond to indices 0 and 3.
        //printf("%s, %s, %s, %s<br>\n", $row[0],  $row[1],  $row[2], $row[3]);

        //affiche le tableau en forme
        // print_r("<pre>\n");
        // print_r($values_collaborateurs);
        // print_r("<pre>\n");
        // printf("<br>\n");//passage a la ligne

        //AFFICHE MISSIONS
        // Print columns A and D, which correspond to indices 0 and 3.
        //printf("%s, %s, %s, %s<br>\n", $row[0],  $row[1],  $row[2], $row[3]);
        //affiche le tableau en forme
        // print_r("<pre>\n");
        // print_r($values_missions);
        // print_r("<pre>\n");
        // printf("<br>\n");//passage a la ligne


        ?>
