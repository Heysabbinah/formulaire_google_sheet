<?php


include_once __DIR__ . '/vendor/autoload.php';
include_once "./base.php";


function google_connexion_spreadsheet(){

  global $client;
  global $accessToken;

  $client = new Google_Client();
  $client->setApplicationName("collaborateur-formulaire");
  $client->useApplicationDefaultCredentials();
  $client->setScopes(['https://www.googleapis.com/auth/drive', 'https://spreadsheets.google.com/feeds', 'https://docs.google.com/feeds']);

  $tokenArray = $client->fetchAccessTokenWithAssertion();
  $accessToken = $tokenArray["access_token"];

}


function new_record(){

     global $client;
     global $idSheet;
     global $range;
     global $accessToken;

     //here le count pour avoir les id des collab automatiquement
     $service = new Google_Service_Sheets($client); /** ici add sheets instead of books  */
     $response = $service->spreadsheets_values->get($idSheet, $range); //ici recolte les values
     $values_collaborateurs = $response->getValues(); //ici stock les values
     $id_collaborateur = count($values_collaborateurs);//count les values
     $id_collaborateur++;

     //Uncomment to add a row to the sheet
     $url = "https://spreadsheets.google.com/feeds/list/$idSheet/od6/private/full";
     $method = 'POST';
     $headers = ["Authorization" => "Bearer $accessToken", 'Content-Type' => 'application/atom+xml'];
     $postBody = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:gsx="http://schemas.google.com/spreadsheets/2006/extended"><gsx:id-collaborateur>'.$id_collaborateur.'</gsx:id-collaborateur><gsx:nom-collaborateur>'.$_POST['nom-collaborateur'].'</gsx:nom-collaborateur><gsx:email>'.$_POST['email'].'</gsx:email><gsx:fonction>'.$_POST['fonction'].'</gsx:fonction><gsx:seniorite>'.$_POST['seniorite'].'</gsx:seniorite></entry>';
     $httpClient = new GuzzleHttp\Client(['headers' => $headers]);
     $resp = $httpClient->request($method, $url, ['body' => $postBody]);

}


function edit_record(){

    global $idSheet;
    global $accessToken;

    $rowid_path = parse_url($_POST['rowId'], PHP_URL_PATH);
    $rowid_path2array = explode("/", $rowid_path);
    $i = count($rowid_path2array);
    $i--;
    $rowid = $rowid_path2array[$i];

    $etag = $_POST['etag'];
    $url = "https://spreadsheets.google.com/feeds/list/$idSheet/od6/private/full/$rowid";
    $method = 'PUT';
    $headers = ["Authorization" => "Bearer $accessToken", 'Content-Type' => 'application/atom+xml', 'GData-Version' => '3.0'];
    //$postBody = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:gsx="http://schemas.google.com/spreadsheets/2006/extended" xmlns:gd="http://schemas.google.com/g/2005" gd:etag="'.$etag.'"><id>https://spreadsheets.google.com/feeds/list/'.$idSheet.'/od6/'.$rowid.'</id><gsx:id-collaborateur>'.$_POST['id-collaborateur'].'</gsx:id-collaborateur><gsx:nom-collaborateur>'.$_POST['nom-collaborateur'].'</gsx:nom-collaborateur><gsx:email>'.$_POST['email'].'</gsx:email><gsx:fonction>'.$_POST['fonction'].'</gsx:fonction><gsx:seniorite>'.$_POST['seniorite'].'</gsx:seniorite></entry>';
    $postBody = "<entry xmlns=\"http://www.w3.org/2005/Atom\" xmlns:gsx=\"http://schemas.google.com/spreadsheets/2006/extended\" xmlns:gd=\"http://schemas.google.com/g/2005\" gd:etag='&quot;$etag&quot;'><id>https://spreadsheets.google.com/feeds/list/$idSheet/od6/$rowid</id><gsx:id-collaborateur>".$_POST['id-collaborateur']."</gsx:id-collaborateur><gsx:nom-collaborateur>".$_POST['nom-collaborateur']."</gsx:nom-collaborateur><gsx:email>".$_POST['email']."</gsx:email><gsx:fonction>".$_POST['fonction']."</gsx:fonction><gsx:seniorite>".$_POST['seniorite']."</gsx:seniorite></entry>";

    $httpClient = new GuzzleHttp\Client(['headers' => $headers]);
    $resp = $httpClient->request($method, $url, ['body' => $postBody]);

}


function google_spreasheet_to_array() {

    global $idSheet;
    global $accessToken;
    global $values_collaborateurs;

    $url = "https://spreadsheets.google.com/feeds/list/$idSheet/od6/private/full";
    $method = 'GET';
    $headers = ["Authorization" => "Bearer $accessToken", "GData-Version" => "3.0"];
    $httpClient = new GuzzleHttp\Client(['headers' => $headers]);
    $resp = $httpClient->request($method, $url);
    $body = $resp->getBody()->getContents();
    $tableXML = simplexml_load_string($body);

  //declare les variable pr recup le table data de la boucle qui va stocker
    $form_number = 0;
    $row_indice = 0;
    $values_collaborateurs = array();//ici je remet a zero

  //boucle pour recuperer les donnees du table avec etag et rowId
    foreach ($tableXML->entry as $entry) {
      $etag = $entry->attributes('gd', TRUE);
      $id = (array)$entry->id;//pour transformer un objetXML

        //la deuxieme boucle pour le passage des values collab et array pr transformer les simpleobject en array pr pouvoir les recup
        //permet de remplir le tableaux avec le xml plutot qu'avec l'ancien code newclientservice etc..
        foreach ($entry->children('gsx', TRUE) as $column) {
          $colName = $column->getName();
          $colValue = (array)$column;//pr transforer un objetXML
          $values_collaborateurs[$row_indice][$colName] = $colValue[0] ;

        }
          $values_collaborateurs[$row_indice]['etag'] = substr($etag, 1, -1);
          $values_collaborateurs[$row_indice]['rowId'] = $id[0];

          $form_number++;//incremente la boucle qui va continuer
          $row_indice++;//idem

    }

          $_SESSION['values_collaborateurs'] = $values_collaborateurs;
}
?>
