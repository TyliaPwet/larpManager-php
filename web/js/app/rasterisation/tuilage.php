<?php
// UTILISATION DU SCRIPT
// Ce script crée les tuiles pour un niveau de zoom donné
// APPEL DU SCRIPT : en ligne de commande, param1 = un entier représentant le niveau de zoom (entre 2 et 6)
// param2 = une chaine représentant le nom du fichier à découper hors extansion .png (|| pour le zoom 6, la racine du nom de fichier hors "_col_line.png"
// param3 = le rep où placer les tuiles en sortie (créé si n'existe pas)
// exemple pour le zoom 6 : php tuilage.php 6 z6 /home/tylia/pyrz6

// A FAIRE : des contrôles mieux que ça et gestion d'erreur!!!!
if ($argc != 4) {
	echo("paramètres invalides\nAttendus :\nParamètre 1 : int = le niveau de zoom (entre 2 et 6)\nParamètre 2 : string = le nom du fichier en entrée (hors extension)\nParamètre 3 : le rep de sortie");
	exit -1;
}
$z = intval($argv[1]);
$nomfichier = $argv[2];
$destination = $argv[3];

// ****A FAIRE : gestion d'erreur si le fichier image n'existe pas !!!!!!!!!********

// les paramètres de carte sont écrits en dur, à rendre paramétrable, notamment quand la config sera en base de données
// dimensions de référence pour la carte = le plus grand niveau de détail/de zoom
$mapWidth = 16384;
$mapHeight = 11264;
$maxZoom = 6;
$minZoom = 2;
$tileWidth = 256;
$tileHeight = 256;

// Cas particulier du zoom 6 
// les images constituant la grande image théorique
if ($z>=6) {
	$subPerLine = 2;
	$subPerCol = 2;
	$nbTampons = 3;
	$tamponWidth = $tileWidth * $nbTampons;
	$tamponHeight = $tileHeight * $nbTampons;
	$subWidth = $mapWidth/2 + $tileWidth*3;
	$subHeight = $mapHeight/2 + $tileHeight*3;
	$subTilesX = $mapWidth/$tileWidth/$subPerCol; // =32: nb de tuiles de large à garder dans chaque image constituante
	$subTilesY = $mapHeight/$tileHeight/$subPerLine; // =22: nb de tuiles de haut à garder dans chaque image constituante

	// donc pour le tuilage :
	// colonne0, ligne0 : on prend 32 tuiles de large en partant du 0, et 22 tuiles de haut en partant du 0
	// colonne0, ligne1 : on prend 32 tuiles de large en partant du 0, et 22 tuiles de haut en partant de la fin
	// colonne1, ligne0 : on prend 32 tuiles de large en partant de la fin, et 22 tuiles de haut en partant du 0
	// colonne1, ligne1 : on prend 32 tuiles de large en partant de la fin, et 22 tuiles de haut en partant de la fin

	// sur disque, la pyramide doit être de la forme : un rep par colonne, contenant une image par ligne, numérotés à partir de 0
	// origine en haut à gauche, comme l'image.. ca tombe bien
	
	echo("..............ZOOM 6..............\n");
		if (!file_exists($destination)) {
			mkdir($destination); // droits max par défaut
		} 
	for ($subCol=0; $subCol<$subPerCol; $subCol++) {
		for ($subLine=0; $subLine<$subPerLine; $subLine++) {

			$image = new \Imagick();
			$image->readImage($nomfichier."_".$subCol."_".$subLine.".png");			

			for ($col=0 ; $col < $subTilesX ; $col++)  { 
				$diskCol = $col + $subCol*$subTilesX; // si on est dans la colonne 1, on veut travailler avec les colonnes à partir de 32
				$decaleX = $subCol == 0 ? 0 : $tamponWidth;	// et dans ce cas il faut sauter les 3 premières tuiles qui sont tampon
				
				// si le rep n'existe pas on le crée
				if (!file_exists($destination."/".$diskCol)) {
					mkdir($destination."/".$diskCol); // droits max par défaut
				} 
				
				for ($line=0; $line < $subTilesY ; $line++) {
					$diskLine = $line + $subLine*$subTilesY;
					$decaleY = $subLine == 0 ? 0 : $tamponHeight;
					echo ("traitement de l'image ".$diskCol.":".$diskLine."\r");
					
					$copie = clone($image);
					$copie->cropImage($tileWidth, $tileHeight, $tileWidth*$col+$decaleX, $tileHeight*$line+$decaleY);
					$copie->setImageFormat("png");
					$copie->writeImage($destination."/".$diskCol."/".$diskLine.".png");
				}			
			}
		}
	}
}



// Autres niveaux de zoom

if ($z>=$minZoom && $z<$maxZoom) {
	echo("..............ZOOM ".$z."..............\n");
	$image = new \Imagick();
	$image->readImage($nomfichier.".png");
	
	$imgWidth = $image->getImageWidth();
	$imgHeight = $image->getImageHeight();
	
	$nbCols = ceil($imgWidth/$tileWidth);
	$nbLines = ceil($imgHeight/$tileHeight);
	
	if (!file_exists($destination)) {
		mkdir($destination); // droits max par défaut
	} 
	
	for ($col=0 ; $col < $nbCols ; $col++)  { 
		// si le rep n'existe pas on le crée
		if (!file_exists($destination."/".$col)) {
			mkdir($destination."/".$col); // droits max par défaut
		} 
		
		for ($line=0; $line < $nbLines ; $line++) {
			echo ("traitement de l'image ".$col.":".$line."\r");
			
			$copie = clone($image);	// parce qu'on ne peut pas crop plusieurs fois la même image et que le clone est plus rapide que réouvrir le fichier
			
			if ($tileHeight*$line > $imgHeight) { 
				// cas particulier au z3 et z2 : la dernière ligne de chaque colonne fait moins de 256 pixels
				// le cropImage ne peut pas crop qqchose de plus grand que l'image (il ne complète pas automatiquement avec du fond) => erreur d'exécution
				// on crop donc seulement ce qui reste et on le colle dans une nouvelle image de 256 pixels
				// note qu'on n'a pas le problème pour les colonnes parce que la taille est toujours divisible par 256
				$partialHeight = $imgHeight - $tileHeight*($line); 
				$copie->cropImage($tileWidth, $tileHeight, $tileWidth*$col, $partialHeight);
				
				$tile = new \Imagick();
				$tile->newImage($tileWidth, $tileHeight, new ImagickPixel('transparent'));
				$tile->setImageFormat("png");
				$tile->compositeImage($copie, Imagick::COMPOSITE_DEFAULT, 0,0);
				$tile->writeImage($destination."/".$col."/".$line.".png");
				
				// Revoir si on peut améliorer l'algo ou utiliser une autre fonction que crop ou des options qui éviteraient de faire ce traitement spécial
				
			} else {
				$copie->cropImage($tileWidth, $tileHeight, $tileWidth*$col, $tileHeight*$line);
				$copie->writeImage($destination."/".$col."/".$line.".png");
			}
		}			
	}
}

echo("..............TUILAGE TERMINE..............\n");

?>
