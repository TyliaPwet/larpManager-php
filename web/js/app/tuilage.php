<?php
$tileWidth = 256;
$tileHeight = 256;
//$imageWidth = 16384;
//$imageHeight = 11264;
$imageWidth = 8960;
$imageHeight = 6400;

$nomPyr = "pyrz6";

$nbLines = $imageHeight / $tileHeight; 
$nbCols = $imageWidth / $tileWidth;

// sur disque, il y a un rep par colonne, contenant une image par ligne, numérotés à partir de 0
// origine en haut à gauche, comme l'image.. ca tombe bien

for ($col=0 ; $col < $nbCols ; $col++) {
	// si le rep n'existe pas on le crée
	if (!file_exists($nomPyr."/".$col)) {
		mkdir($nomPyr."/".$col); // droits max par défaut
	} 
	
	$image = new \Imagick();
	$image->readImage("layer.png");	
	
	// on extrait toute la colonne qu'on redécoupera juste apès, pour optimisation
	$image->cropImage($tileWidth, $imageHeight, $tileWidth*$col, 0);
	$image->writeImage($nomPyr."/".$col."/total.png");  

	
	for ($line=0; $line < $nbLines ; $line++) {
	echo ("traitement de l'image ".$col.":".$line."\r");
		$imageCol = new \Imagick();
		$imageCol->readImage($nomPyr."/".$col."/total.png");	
		$imageCol->cropImage($tileWidth, $tileHeight, 0, $tileHeight*$line);
		$imageCol->writeImage($nomPyr."/".$col."/".$line.".png");  

	}
	
	// on supprime le fichier colonne qu'on avait créé
	//unlink($nomPyr."/".$col."/total.png");
}


?>
