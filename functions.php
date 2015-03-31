<?php
function getUrl($url)
{
// Tableau contenant les options de t�l�chargement
$options=array(
      CURLOPT_URL            => $url, // Url cible (l'url la page que vous voulez t�l�charger)
      CURLOPT_RETURNTRANSFER => true, // Retourner le contenu t�l�charg� dans une chaine (au lieu de l'afficher directement)
      CURLOPT_HEADER         => false // Ne pas inclure l'ent�te de r�ponse du serveur dans la chaine retourn�e
);
$CURL=curl_init();
      curl_setopt_array($CURL,$options);
      $content=curl_exec($CURL);      // Le contenu t�l�charg� est enregistr� dans la variable $content. Libre � vous de l'afficher.
curl_close($CURL);
}

function suppr_accents($str, $encoding='utf-8')
{
	$str = mb_strtolower($str, 'UTF-8');
    // transformer les caract�res accentu�s en entit�s HTML
    $str = htmlentities($str, ENT_NOQUOTES, $encoding);
 
    // remplacer les entit�s HTML pour avoir juste le premier caract�res non accentu�s
    // Exemple : "&ecute;" => "e", "&Ecute;" => "E", "� " => "a" ...
    $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
 
    // Remplacer les ligatures tel que : �, � ...
    // Exemple "œ" => "oe"
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
    // Supprimer tout le reste
    $str = preg_replace('#&[^;]+;#', '', $str);
 
    return $str;
}
?>