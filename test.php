<?Php

set_include_path(PATH_SEPARATOR . get_include_path());
require_once 'google/Client.php';
require_once 'google/Service/Analytics.php';

//Votre code site analytics. Quand vous consultez les stats d'un site avec cette url dans Analytics :
//https://www.google.com/analytics/web/#report/visitors-overview/abcd1234666p987365432/
//C'est le code se trouvant après le "p" soit : 987365432
define('ga_site','170955762');

$client = new Google_Client();
$client->setApplicationName("Mon Applicatin Test"); // Nom de votre application

// set assertion credentials
$client->setAssertionCredentials(
  new Google_Auth_AssertionCredentials(

    "test-api-dolibarr@test-dolibarr-197313.iam.gserviceaccount.com", // email sous la forme 123456789101112-abcdefghijkl@developer.gserviceaccount.com

    array('https://www.googleapis.com/auth/analytics.readonly'),

    file_get_contents("Test-dolibarr-817474601eda.json")  // Chemin vers le fichier p12

));

// other settings
$client->setClientId("test-api-dolibarr@test-dolibarr-197313.iam.gserviceaccount.com
");           // Client ID 
$client->setAccessType('offline_access');  // Trouver sur un autre site mais pas certain que cela serve vraiment

// create service and get data
$service = new Google_Service_Analytics($client);

//Pour les visiteurs :
$dimensions = 'ga:date,ga:year,ga:month,ga:day'; //Format de la date

$gaData = 
      $service->data_ga->get( 
        'ga:' . ga_site,
        "2018-03-04",
        "2018-03-08",
        'ga:visitors',
        array('dimensions' => $dimensions)
      );

var_dump($gaData);

//Attention: cela donnera le résultat total pour le créneau de date choisi : si sur deux jours, ce sera le total pour les deux jours !!
//Sinon , il faut parcourir les "rows"
//var_dump($gaData->totalsForAllResults["ga:visitors"]);
?>