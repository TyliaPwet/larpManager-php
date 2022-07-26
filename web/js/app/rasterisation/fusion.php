<?php
// UTILISATION DU SCRIPT
// Fusion du fond vide et de la surcouche
// Comme on a que le fond vide tuilé, on fait la fusion tuile par tuile

// APPEL DU SCRIPT : en ligne de commande, param1 = un entier représentant le niveau de zoom (entre 2 et 6)
// param2 = chemin d'accès à la pyramide image fond vide
// param3 = chemin d'accès à la pyramide de tuiles que nous avons créée avec layers.php et tuilage.php
// param4 = chemin d'accès à la pyramide fusionnée
// exemple pour le zoom 3 : php fusion.php 3 /var/www/larpmanager/img/map_clean /home/tylia/pyrz3 /var/www/larpmanager/img/map_new

// A FAIRE : des contrôles mieux que ça et gestion d'erreur!!!!
if ($argc != 5) {
	echo("paramètres invalides\nAttendus :\nParamètre 1 : int = le niveau de zoom (entre 2 et 6)\n");
	echo("Paramètre 2 = chemin d'accès à la pyramide image fond vide (hors niveau de zoom)\n");
	echo("Paramètre 3 = chemin d'accès à la pyramide image png à superposer (hors niveau de zoom)\n");
	echo("Paramètre 4 = chemin d'accès à la pyramide cible (hors niveau de zoom)\n");
	exit -1;
}
$z = intval($argv[1]);
$pyr_fond_vide = $argv[2];
$pyr_layer_png = $argv[3];
$pyr_cible = $argv[4];

/*
$pyr_fond_vide="/var/www/larpmanager/larpManager-php/web/img/map_clean";
$pyr_layer_png="/var/www/larpmanager/larpManager-php/web/img/map_custom";
$pyr_cible="/var/www/larpmanager/larpManager-php/web/img/map_new";
*/

$minZoom=2;
$maxZoom=6;

if ($z>=$minZoom && $z<=$maxZoom) {
	echo("Traitement du zoom ".$z."......................\n");
	
	if(!file_exists($pyr_cible."/".$z)) {
		echo("Création du rep ".$pyr_cible."/".$z."\n");
		mkdir($pyr_cible."/".$z);
	}
	
	for ($col=0; file_exists($pyr_fond_vide."/".$z."/".$col); $col++) {
		echo("\ncolonne ".$col."\n");
		for ($line=0; file_exists($pyr_fond_vide."/".$z."/".$col."/".$line.".png"); $line++){
			//echo("ligne ".$line);
			
			if (file_exists($pyr_layer_png."/".$z."/".$col."/".$line.".png")) {
				//echo(" : image ".$pyr_layer_png."/".$z."/".$col."/".$line.".png trouvée\n");
				
				$tile = new \Imagick();
				$tile->readImage($pyr_fond_vide."/".$z."/".$col."/".$line.".png");
				
				$layer = new \Imagick();
				$layer->readImage($pyr_layer_png."/".$z."/".$col."/".$line.".png");
				
				$tile->compositeImage($layer, Imagick::COMPOSITE_DEFAULT, 0,0);
				
				if (!file_exists($pyr_cible."/".$z."/".$col)) {
					echo("Création du rep ".$pyr_cible."/".$z."/".$col."\n");
					mkdir($pyr_cible."/".$z."/".$col);
				}
				
				echo("enregistrement de ".$line.".png\r");
				$tile->writeImage($pyr_cible."/".$z."/".$col."/".$line.".png");
			} else {
				echo("Erreur fichier ".$pyr_layer_png."/".$z."/".$col."/".$line.".png absent\n");
			}
		}
	}
}
?>
