<?php
 
include 'tableaux.php';
include 'functions.php';

//setup PHP UTF-8 stuff
setlocale(LC_CTYPE, 'fr_FR.UTF-8');
 
//read parameters from HTTP Get URL
$phone = $_GET["phone"]; // numero de telephone, info donner par SMS Gateway
$smscenter = $_GET["smscenter"]; // numero de centre de messagerie, info donner par SMS Gateway mais non utilisé
$text_utf8 = rawurldecode($_GET["text"]); // commande qui sera traité par le script
$login = rawurldecode($_GET["login"]); // login utilisé par le HC2
$password = rawurldecode($_GET["password"]); //mot de pass utilisé par le HC2 et a configurer sur SMS Gateway
$url = null;
$reponse = null;
$request = null;

//variable a modifier
$hc2ip = "192.168.2.3";
$smsgatewayip = "192.168.2.23"


// traitement de la chaine texte, on converti les accents et on apsse tout en minuscule
$text_utf8 = suppr_accents($text_utf8);

// on decoupe le texte pour identifier les pieces, modules et actions a réaliser
$items = explode(" ",$text_utf8);
$room = $items[1];
$device = $items[0];
$action = $items[2];


// On vérifie dans le tableaux.php si les modules sont présent si oui on défini l'action
foreach($devices as  $key =>$v1)
{
	foreach ($v1 as  $key2 =>$v2)
	{
		if($key == $room && $key2 == $device)
		{
				for($i=0; $i<$commandes; $i++)
				{
					if($commandes[$i][0] == $action){
					$request = "/api/callAction?deviceID=" . $v2 . "&name=" . $commandes[$i][1];
					
					$reponse = "HC2: " . $key2 . " " . $key . " " . $commandes[$i][2] ;
					break;
					} else {
					$reponse = "Appareil ".$device." dans ".$room." n'existe pas.";
					}
				}
		}
	}
}

// on lance les actions et le retour par SMS sur le statut de l'action
getUrl($url = "http://" . $login . ":" . $password . "@" . $hc2ip . $request);
getUrl($url2 = "http://" . $smsgatewayip . ":9090/sendsms?phone=" . $phone . "&text=" . urlencode($reponse) . "&password=" . $password);
?>