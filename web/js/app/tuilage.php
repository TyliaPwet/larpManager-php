<?php
// ce script permet de générer toutes les tuiles pour tous les niveaux de zooms de 6 à 2 (les niveaux 1 et 0 étant inutiles en dehors de la miniMap, la pyramide image vide actuelle suffit)
// les fichiers doivent être au même emplacement que ce script
// les fichiers image à tuiler doivent porter le nom z[niveau de zoom].png 
// (exception pour le zoom 6 qui comporte 4 images qui se recoupent, traité différemment; les images sont nommées z6_[colonne]_[ligne].png)

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
/*
echo("..............ZOOM 6..............\n");
	if (!file_exists("z6")) {
		mkdir("z6"); // droits max par défaut
	} 
for ($subCol=0; $subCol<$subPerCol; $subCol++) {
	for ($subLine=0; $subLine<$subPerLine; $subLine++) {

		$image = new \Imagick();
		$image->readImage("z6_".$subCol."_".$subLine.".png");			

		for ($col=0 ; $col < $subTilesX ; $col++)  { 
			$diskCol = $col + $subCol*$subTilesX; // si on est dans la colonne 1, on veut travailler avec les colonnes à partir de 32
			$decaleX = $subCol == 0 ? 0 : $tamponWidth;	// et dans ce cas il faut sauter les 3 premières tuiles qui sont tampon
			
			// si le rep n'existe pas on le crée
			if (!file_exists("z".$z."/".$diskCol)) {
				mkdir("z".$z."/".$diskCol); // droits max par défaut
			} 
			
			for ($line=0; $line < $subTilesY ; $line++) {
				$diskLine = $line + $subLine*$subTilesY;
				$decaleY = $subLine == 0 ? 0 : $tamponHeight;
				echo ("traitement de l'image ".$diskCol.":".$diskLine."\r");
				
				$copie = clone($image);
				$copie->cropImage($tileWidth, $tileHeight, $tileWidth*$col+$decaleX, $tileHeight*$line+$decaleY);
				$copie->writeImage("z".$z."/".$diskCol."/".$diskLine.".png");
			}			
		}
	}
}
*/


// Autres niveaux de zoom
//for ($z=$maxZoom-1; $z>=$minZoom ; $z--) {
for ($z=5; $z>=3 ; $z--) {
	echo("..............ZOOM ".$z."..............\n");
	$image = new \Imagick();
	$image->readImage("z".$z.".png");
	
	$imgWidth = $image->getImageWidth();
	$imgHeight = $image->getImageHeight();
	
	$nbCols = ceil($imgWidth/$tileWidth);
	$nbLines = ceil($imgHeight/$tileHeight);
	
	if (!file_exists("z".$z)) {
		mkdir("z".$z); // droits max par défaut
	} 
	
	for ($col=0 ; $col < $nbCols ; $col++)  { 
		// si le rep n'existe pas on le crée
		if (!file_exists("z".$z."/".$col)) {
			mkdir("z".$z."/".$col); // droits max par défaut
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
				$tile->writeImage("z".$z."/".$col."/".$line.".png");
				
				// Revoir si on peut améliorer l'algo ou utiliser une autre fonction que crop ou des options qui éviteraient de faire ce traitement spécial
				
			} else {
				$copie->cropImage($tileWidth, $tileHeight, $tileWidth*$col, $tileHeight*$line);
				$copie->writeImage("z".$z."/".$col."/".$line.".png");
			}
		}			
	}
}

echo("..............TUILAGE TERMINE..............\n");

?>
