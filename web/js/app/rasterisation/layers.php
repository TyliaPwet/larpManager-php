<?php
// UTILISATION DU SCRIPT
// Ce script permet de générer l'image (ou les images) png complètes pour un niveau de zoom donné
// APPEL DU SCRIPT en ligne de commande, param1 = un entier représentant le niveau de zoom (entre 2 et 6), param2 = une chaine représentant le nom du fichier en sortie, hors extansion .png
// exemple pour le zoom 5 : 		php layers.php 5 z5

// A FAIRE : des contrôles mieux que ça et gestion d'erreur!!!!
if ($argc != 3) {
	echo("paramètres invalides\nAttendus :\nParamètre 1 : int = le niveau de zoom (entre 2 et 6)\nParamètre 2 : string = le nom du fichier en sortie (hors extension)");
	exit -1;
}
$z = intval($argv[1]);
$nomfichier = $argv[2];


//*********************************************************************************
//*** FONCTIONS UTILES
//*********************************************************************************
function LonToPix(float $x) {
    $res = $x*64;
    return $res;
}

function LatToPix(float $y) {
	$res = -$y*64;
	return $res;
}

// à charger depuis la bdd quand elle y sera
$configLayers = array(
	array("name"=>"label_pays", "type"=>"label", "zoom"=>[2,3], "style"=> array("size"=>192, "font"=>"./fonts/TrajanPro-Regular.otf", "interl"=>250, "toUpper"=>true, "strokeColor"=>"#705948", "strokeWidth"=>1, "fillColor"=>"#705948", "rectif"=>48)),
	array("name"=>"label_pays", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>192, "font"=>"./fonts/TrajanPro-Regular.otf", "interl"=>250, "toUpper"=>true, "strokeColor"=>"#FFFFFF", "strokeWidth"=>1, "fillColor"=>"#FFFFFF", "rectif"=>48)),
	array("name"=>"lim_fief", "type"=>"line", "zoom"=>[4,5,6], "style"=> array("strokeColor"=>"#8E6F58", "strokeWidth"=>[2,4,4], "dashArray"=>[[2,2,6,6], [4,4,12,12], [4,4,12,12]], "strokeCap"=>"butt")),
	array("name"=>"lim_pays", "type"=>"line", "zoom"=>[2,3,4,5,6], "style"=> array("strokeColor"=>"#8B0004", "strokeWidth"=>[2,3,4,8,16], "dashArray"=>[[6,4],[8,6],[12,8],[24,16],[48,32]], "strokeCap"=>"butt")),
	array("name"=>"caravane", "type"=>"line", "zoom"=>[4,5,6], "style"=> array("strokeColor"=>"#6600A1", "strokeWidth"=>[8,16,32], "dashArray"=>[[3,3,6,6], [6,6,12,12], [12,12,24,24]], "strokeCap"=>"butt")),
	array("name"=>"exploration", "type"=>"picto", "zoom"=>[2,3,4,5,6], "style"=> array("src"=>"./img/exploration_gd.png")),
	array("name"=>"ville", "type"=>"cercle", "zoom"=>[4,5,6], "style"=> array("radius"=>24, "fillColor"=>"#8B0004")),
	array("name"=>"capitale", "type"=>"cercle", "zoom"=>[4,5,6], "style"=> array("radius"=>24, "fillColor"=>"#8B0004")),
	array("name"=>"label_poi", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>40, "toUpper"=>false, "strokeColor"=>"#555555", "strokeWidth"=>1, "fillColor"=>"#555555", "rectif"=>9)),
	array("name"=>"label_riviere", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>32, "font"=>"./fonts/Livingst.ttf", "interl"=>30, "toUpper"=>false, "strokeColor"=>"#245579", "strokeWidth"=>1, "fillColor"=>"#245579", "rectif"=>3)),
	array("name"=>"label_passe", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>40, "toUpper"=>false, "strokeColor"=>"#8B0004", "strokeWidth"=>1, "fillColor"=>"#8B0004", "rectif"=>9)),
	array("name"=>"label_fief", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>64, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#000000", "strokeWidth"=>1, "fillColor"=>"#000000", "rectif"=>14)),
	array("name"=>"label_ville", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>40, "toUpper"=>false, "strokeColor"=>"#555555", "strokeWidth"=>1, "fillColor"=>"#555555", "rectif"=>9)),
	array("name"=>"label_capitale", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>40, "toUpper"=>false, "strokeColor"=>"#8B0004", "strokeWidth"=>1, "fillColor"=>"#8B0004", "rectif"=>9))
);

// paramètres carte
$mapWidth = 16384;
$mapHeight = 11264;
$zoomFactor = 2;
$maxZoom = 6;
$minZoom = 2;


//**********************************************************************************
//*** DEBUT 
//**********************************************************************************
if($z>=$minZoom && $z<$maxZoom) {	
	$divFactor = pow($zoomFactor, $maxZoom-$z);
	$imgWidth = $mapWidth / $divFactor;
	$imgHeight = $mapHeight / $divFactor;
	
	$image = new \Imagick();
	$image->newImage($imgWidth, $imgHeight, new ImagickPixel('transparent'));
	$image->setImageFormat("png");
	$image->setImageFilename($nomfichier.".png");

	foreach($configLayers as $layer) {
		echo("...layer ".$layer["name"]." : ");

		$i = array_search($z, $layer["zoom"]);
		if ($i === false) { 
			echo("XXX\n");
			continue; 
		}
		
		$url = 'http://localhost:8080/worldmap/features/get/'.$layer["name"];
		$content = file_get_contents($url);
		$elems = json_decode($content, true);
		
		switch ($layer["type"]) {
			case "label":
				echo("traitements des labels\n");
		   		$draw = new \ImagickDraw();
				$draw->setStrokeColor($layer["style"]["strokeColor"]);
				$draw->setFillColor($layer["style"]["fillColor"]);
				$draw->setStrokeWidth($layer["style"]["strokeWidth"]);
				$draw->setFontSize($layer["style"]["size"]/$divFactor);
				$draw->setFont($layer["style"]["font"]);
				$draw->setTextAlignment(imagick::ALIGN_CENTER);
		
				foreach($elems as $elem) {
					preg_match('#\[(.+),(.+)\]#', $elem["geom"], $matches);

					$x = round(LonToPix(floatval($matches[1])));
					$y = round(LatToPix(floatval($matches[2])))+$layer["style"]["rectif"];
									
					// on split les textes sur plusieurs lignes
					$tmp = ($layer["style"]["toUpper"]) ? mb_strtoupper($elem["texte"]) : $elem["texte"];
					$lignes = explode("#", $tmp);
					
					foreach($lignes as $ligne=>$texte) {
						$newx = $x/$divFactor;
						$newy = ($y + $ligne*$layer["style"]["interl"])/$divFactor; 
						$image->annotateImage($draw, $newx, $newy, $elem["rotation"], $texte);							
					}			
				
				}
				break;
		

			case "cercle" :
				$draw = new \ImagickDraw();
				$draw->setStrokeColor($layer["style"]["fillColor"]);
				$draw->setFillColor($layer["style"]["fillColor"]);
				$radius = $layer["style"]["radius"]/$divFactor;
				
				echo("traitements des cercles\n");
				
				foreach($elems as $elem) {
					preg_match('#\[(.+),(.+)\]#', $elem["geom"], $matches);

					$x = round(LonToPix(floatval($matches[1])))/$divFactor;
					$y = round(LatToPix(floatval($matches[2])))/$divFactor;

					$draw->circle($x, $y, $x+$radius, $y);
				}
				$image->drawImage($draw);				
	    		break;


			case "line":
				echo("traitements des tracés\n");
				$draw = new \ImagickDraw();
				$draw->setStrokeColor($layer["style"]["strokeColor"]);
				$draw->setFillColor('transparent'); 
				$draw->setStrokeWidth($layer["style"]["strokeWidth"][$i]);
				$draw->setStrokeDashArray($layer["style"]["dashArray"][$i]);
				$draw->setStrokeLineCap(imagick::LINECAP_BUTT);
				
				foreach($elems as $elem) {
					$tabcoords = array();
					preg_match_all('#(\[[0-9\-\.]+,[0-9\-\.]+\])#', $elem["geom"], $paires);

					foreach($paires[1] as $paire) {				
						preg_match('#\[(.+),(.+)\]#', $paire, $coords);
						$x = round(LonToPix(floatval($coords[1])))/$divFactor;
						$y = round(LatToPix(floatval($coords[2])))/$divFactor;
						$tabcoords[] = array("x"=>$x, "y"=>$y);
					}
					
					$draw->polyline($tabcoords);
				}
				$image->drawImage($draw);												
				break;
				
			case "picto":
				echo("traitements des pictos\n");

				$picto = new \Imagick();
				$picto->readImage($layer["style"]["src"]);
				$w = $picto->getImageWidth();
				$h = $picto->getImageHeight();
				$pictoWidth = $w/$divFactor;
				$pictoHeight = $h/$divFactor;
				$picto->scaleImage($pictoWidth, $pictoHeight);
				
				foreach($elems as $elem) {
					preg_match('#\[(.+),(.+)\]#', $elem["geom"], $matches);

					$x = (round(LonToPix(floatval($matches[1]))) - $w/2)/$divFactor;
					$y = (round(LatToPix(floatval($matches[2]))) - $h/2)/$divFactor;

					$image->compositeImage($picto, Imagick::COMPOSITE_DEFAULT, $x,$y);
				}			
				
				break;
			default :
				echo("type de couche ".$layer["type"]." non pris en charge\n");
				break;
		}

	}
	$image->writeImage();
}


// ZOOM 6 cas particulier
if ($z==$maxZoom) {
	// l'image z6 finale est trop grande pour être correctement gérée par Imagick
	// de plus le tuilage est ensuite plus rapide si on travaille sur des images plus petites
	// on définit donc un découpage de l'image totale, avec une marge tampon pour le recollage 
	// l'idéal serait d'avoir une bdd géographique pour pouvoir sélectionner uniquement les features qui sont dans la zones que nous tarvaillons.? à faire plus tard?
	$nbCols = 2;		
	$nbLines = 2;
	$tileWidth = 256;
	$nbTilesTampon = 3;
	$tampon = $nbTilesTampon*$tileWidth;
	$imgWidth = $mapWidth / $nbCols + $tampon;
	$imgHeight = $mapHeight / $nbLines + $tampon;

	// $delimitations[0] => colonne 0 ; $delimitation[0][0] => colone 0, ligne 0 : $delimitation[0][0]["minx"] etc...
	// A faire : calculer les délimitations et générer le tableau en fonction du nbCols et nbLines
	$delimitations = array( array( array("minx"=>0, "maxx"=>$imgWidth, "miny"=>0, "maxy"=>$imgHeight), array("minx"=>0, "maxx"=>$imgWidth, "miny"=>$mapHeight-$imgHeight, "maxy"=>$mapWidth) ),
							array( array("minx"=>$mapWidth-$imgWidth, "maxx"=>$mapWidth, "miny"=>0, "maxy"=>$imgHeight), array("minx"=>$mapWidth-$imgWidth, "maxx"=>$mapWidth, "miny"=>$mapHeight-$imgHeight, "maxy"=>$mapWidth) ));

	for ($col=0; $col<$nbCols; $col++){
		for($line=0; $line<$nbLines; $line++){

			$image = new \Imagick();
			$image->newImage($imgWidth, $imgHeight, new ImagickPixel('transparent'));
			$image->setImageFormat("png");
			$image->setImageFilename($nomfichier."_".$col."_".$line.".png");
			echo("traitement de l'image ".$col."_".$line."............\n");
		
			$minx = $delimitations[$col][$line]["minx"];
			$maxx = $delimitations[$col][$line]["maxx"];
			$miny = $delimitations[$col][$line]["miny"];
			$maxy = $delimitations[$col][$line]["maxy"];
			$xcorrector = $col*$minx;
			$ycorrector = $line*$miny;
		
			foreach($configLayers as $layer) {
				echo("...layer ".$layer["name"]." : ");
				
				$i = array_search($z, $layer["zoom"]);
				if ($i === false) { 
					echo("XXX\n");
					continue; 
				}
				
				$url = 'http://localhost:8080/worldmap/features/get/'.$layer["name"];
				$content = file_get_contents($url);
				$elems = json_decode($content, true);
				
				switch ($layer["type"]) {
					case "label":
						echo("traitements des labels\n");
				   		$draw = new \ImagickDraw();
						$draw->setStrokeColor($layer["style"]["strokeColor"]);
						$draw->setFillColor($layer["style"]["fillColor"]);
						$draw->setStrokeWidth($layer["style"]["strokeWidth"]);
						$draw->setFontSize($layer["style"]["size"]);
						$draw->setFont($layer["style"]["font"]);
						$draw->setTextAlignment(imagick::ALIGN_CENTER);
				
						foreach($elems as $elem) {
							preg_match('#\[(.+),(.+)\]#', $elem["geom"], $matches);

							$x = round(LonToPix(floatval($matches[1])));
							$y = round(LatToPix(floatval($matches[2])))+$layer["style"]["rectif"];
							
							// on ne traite que si le point est dans la zone de l'image
							if ($x<=$maxx && $x>=$minx && $y<=$maxy && $y>=$miny) {
								// on réajuste les coordonnées en fonction de la sous-image sur laquelle on est
								$xx = $x - $xcorrector;
								$yy = $y - $ycorrector;
							
								//on split les lignes si besoin et on calcule le point d'ancrage pour Gmagick (en bas à gauche et non au centre)
								$tmp = ($layer["style"]["toUpper"]) ? mb_strtoupper($elem["texte"]) : $elem["texte"];
								$lignes = explode("#", $tmp);
								
								foreach($lignes as $ligne=>$texte) {
									$newy = $yy + $ligne*$layer["style"]["interl"]; 
									$image->annotateImage($draw, $xx, $newy, $elem["rotation"], $texte);							
								}			
							}
						}
						break;
				

					case "cercle" :
						$draw = new \ImagickDraw();
						$draw->setStrokeColor($layer["style"]["fillColor"]);
						$draw->setFillColor($layer["style"]["fillColor"]);
						
						echo("traitements des cercles\n");
						
						foreach($elems as $elem) {
							preg_match('#\[(.+),(.+)\]#', $elem["geom"], $matches);

							$x = round(LonToPix(floatval($matches[1])));
							$y = round(LatToPix(floatval($matches[2])));

							// on ne traite que si le point est dans la zone de l'image
							if ($x<=$maxx && $x>=$minx && $y<=$maxy && $y>=$miny) {
								// on réajuste les coordonnées en fonction de la sous-image sur laquelle on est
								$xx = $x - $xcorrector;
								$yy = $y - $ycorrector;
								$draw->circle($xx, $yy, $xx+$layer["style"]["radius"], $yy);
								
							}
						}
						$image->drawImage($draw);				
						break;


					case "line":
						echo("traitements des tracés\n");
						$draw = new \ImagickDraw();
						$draw->setStrokeColor($layer["style"]["strokeColor"]);
						$draw->setFillColor('transparent'); 
						$draw->setStrokeWidth($layer["style"]["strokeWidth"][$i]);
						$draw->setStrokeDashArray($layer["style"]["dashArray"][$i]);
						$draw->setStrokeLineCap(imagick::LINECAP_BUTT);
						
						// décodage du champ geojson + conversion des coordonnées
						foreach($elems as $elem) {
							$tabcoords = array();
							preg_match_all('#(\[[0-9\-\.]+,[0-9\-\.]+\])#', $elem["geom"], $paires);

							foreach($paires[1] as $paire) {				
								preg_match('#\[(.+),(.+)\]#', $paire, $coords);
								$x = round(LonToPix(floatval($coords[1])));
								$y = round(LatToPix(floatval($coords[2])));
								// on réajuste les coordonnées en fonction de la sous-image sur laquelle on est
								$xx = $x - $xcorrector;
								$yy = $y - $ycorrector;
								$tabcoords[] = array("x"=>$xx, "y"=>$yy);
							}
							
							$draw->polyline($tabcoords);
						}
						$image->drawImage($draw);												
						break;
						
					case "picto":
						echo("traitements des pictos\n");

						$picto = new \Imagick();
						$picto->readImage($layer["style"]["src"]);
						$width = $picto->getImageWidth();
						$height = $picto->getImageHeight();
						
						foreach($elems as $elem) {
							preg_match('#\[(.+),(.+)\]#', $elem["geom"], $matches);

							$x = round(LonToPix(floatval($matches[1]))) - $width/2;
							$y = round(LatToPix(floatval($matches[2]))) - $height/2;

							if ($x<=$maxx && $x>=$minx && $y<=$maxy && $y>=$miny) {
								// on réajuste les coordonnées en fonction de la sous-image sur laquelle on est
								$xx = $x - $xcorrector;
								$yy = $y - $ycorrector;
								$image->compositeImage($picto, Imagick::COMPOSITE_DEFAULT, $xx,$yy);
							}
						}			
						
						break;
					default :
						echo("type de couche ".$layer["type"]." non pris en charge\n");
						break;
				}

			}
			
			$image->writeImage();
		}
	}
}


?>
