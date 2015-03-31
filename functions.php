<?php
function getUrl($url)
{
// Tableau contenant les options de téléchargement
$options=array(
      CURLOPT_URL            => $url, // Url cible (l'url la page que vous voulez télécharger)
      CURLOPT_RETURNTRANSFER => true, // Retourner le contenu téléchargé dans une chaine (au lieu de l'afficher directement)
      CURLOPT_HEADER         => false // Ne pas inclure l'entête de réponse du serveur dans la chaine retournée
);
$CURL=curl_init();
      curl_setopt_array($CURL,$options);
      $content=curl_exec($CURL);      // Le contenu téléchargé est enregistré dans la variable $content. Libre à vous de l'afficher.
curl_close($CURL);
}

function suppr_accents($str, $encoding='utf-8')
{
	$str = mb_strtolower($str, 'UTF-8');
    // transformer les caractères accentués en entités HTML
    $str = htmlentities($str, ENT_NOQUOTES, $encoding);
 
    // remplacer les entités HTML pour avoir juste le premier caractères non accentués
    // Exemple : "&ecute;" => "e", "&Ecute;" => "E", "Ã " => "a" ...
    $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
 
    // Remplacer les ligatures tel que : Œ, Æ ...
    // Exemple "Å“" => "oe"
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
    // Supprimer tout le reste
    $str = preg_replace('#&[^;]+;#', '', $str);
 
    return $str;
}
?>