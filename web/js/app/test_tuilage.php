<?php
$nomPyr = "pyrz6";

$tileWidth = 256;
$tileHeight = 256;

// comme imageMagick ne sait pas gérer ses propres grandes images, 
// l'image du z6 a été générée en 4 parties = 2 colonnes x 2 lignes avec recouvrement de 3 tuiles
// la grande image théorique
$z6Width = 16384;
$z6Height = 11264;
$z6TilesX = $z6Width / $tileWidth; //64
$z6TilesY = $z6Height / $tileHeight; //44

// les images constituant la grande image théorique
$subPerLine = 2;
$subPerCol = 2;
$nbTampons = 3;
$tamponWidth = $tileWidth * $nbTampons;
$tamponHeight = $tileHeight * $nbTampons;
$subWidth = 8960; 		// $z6Width/2 + $tileWidth*3
$subHeight = 6400; 		// $s6Height/2 + $tileHeight*3
$subTilesX = $z6TilesX /$subPerLine; // =32: nb de tuiles de large à garder dans chaque image constituante
$subTilesY = $z6TilesY /$subPerCol; // =22: nb de tuiles de haut à garder dans chaque image constituante

// donc pour le tuilage :
// colonne0, ligne0 : on prend 32 tuiles de large en partant du 0, et 22 tuiles de haut en partant du 0
// colonne0, ligne1 : on prend 32 tuiles de large en partant du 0, et 22 tuiles de haut en partant de la fin
// colonne1, ligne0 : on prend 32 tuiles de large en partant de la fin, et 22 tuiles de haut en partant du 0
// colonne1, ligne1 : on prend 32 tuiles de large en partant de la fin, et 22 tuiles de haut en partant de la fin

// sur disque, la pyramide doit être de la forme : un rep par colonne, contenant une image par ligne, numérotés à partir de 0
// origine en haut à gauche, comme l'image.. ca tombe bien

for ($subCol=0; $subCol<$subPerCol; $subCol++) {
	for ($subLine=0; $subLine<$subPerLine; $subLine++) {

		$image = new \Imagick();
		$image->readImage($subCol."_".$subLine.".png");			

		for ($col=0 ; $col < $subTilesX ; $col++)  { 
			$diskCol = $col + $subCol*$subTilesX; // si on est dans la colonne 1, on veut travailler avec les colonnes à partir de 32
			$decaleX = $subCol == 0 ? 0 : $tamponWidth;	// et dans ce cas il faut sauter les 3 premières tuiles qui sont tampon
			
			// si le rep n'existe pas on le crée
			if (!file_exists($nomPyr."/".$diskCol)) {
				mkdir($nomPyr."/".$diskCol); // droits max par défaut
			} 
			
			for ($line=0; $line < $subTilesY ; $line++) {
				$diskLine = $line + $subLine*$subTilesY;
				$decaleY = $subLine == 0 ? 0 : $tamponHeight;
				echo ("traitement de l'image ".$diskCol.":".$diskLine."\r");
				
		//		$image = new \Imagick();
		//		$image->readImage("layer.png");	
				$copie = clone($image);
				$copie->cropImage($tileWidth, $tileHeight, $tileWidth*$col+$decaleX, $tileHeight*$line+$decaleY);
				$copie->writeImage($nomPyr."/".$diskCol."/".$diskLine.".png");
			}
				
	}
}

/*

		
for ($col=0 ; $col < $nbCols ; $col++) {
	// si le rep n'existe pas on le crée
	if (!file_exists($nomPyr."/".$col)) {
		mkdir($nomPyr."/".$col); // droits max par défaut
	} 
	
	for ($line=0; $line < $nbLines ; $line++) {
		echo ("traitement de l'image ".$col.":".$line."\r");
//		$image = new \Imagick();
//		$image->readImage("layer.png");	
		$copie = clone($image);
		$copie->cropImage($tileWidth, $tileHeight, $tileWidth*$col, $tileHeight*$line);
		$copie->writeImage($nomPyr."/".$col."/".$line.".png");
	}
		
	/*
	$image->cropImage($tileWidth, $imageHeight, $tileWidth*$col, 0);
	$image->writeImage($nomPyr."/".$col."/total.png");  

	
	for ($line=0; $line < $nbLines ; $line++) {
	echo ("traitement de l'image ".$col.":".$line."\r");
		$imageCol = new \Imagick();
		$imageCol->readImage($nomPyr."/".$col."/total.png");	
		if(!$imageCol->cropImage($tileWidth, $tileHeight, 0, $tileHeight*$line)) {echo("false!!");}
		$imageCol->writeImage($nomPyr."/".$col."/".$line.".png");  

	}
	*/
	// on supprime le fichier colonne qu'on avait créé
	//unlink($nomPyr."/".$col."/total.png");*/
}


?>
