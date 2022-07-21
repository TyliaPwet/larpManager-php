<?php
//*********************************************************************************
//*** FONCTIONS UTILES
//*********************************************************************************
function LonToPix(int $x) {
    $res = $x*64;
    return $res;
}

function LatToPix(int $y) {
	$res = -$y*64;
	return $res;
}

function createStyle(String $type, Array $tab) {    
    switch($type) {
    	case "label" :
    		$draw = new \ImagickDraw();
		    $draw->setStrokeColor($tab["strokeColor"]);
			$draw->setFillColor($tab["fillColor"]);
			$draw->setStrokeWidth($tab["strokeWidth"]);
			$draw->setFontSize($tab["size"]);
			$draw->setFont($tab["font"]);
			$draw->setTextAlignment(imagick::ALIGN_CENTER);
    		break;
    		
    	case "cercle" :
			$draw = new \ImagickDraw();
		    $draw->setStrokeColor($tab["fillColor"]);
			$draw->setFillColor($tab["fillColor"]);
    		break;
    	default: $draw = false;
    } 
    return $draw;
}

$debut = microtime(true);
//*********************************************************************************
//*** PARAMETRAGE / PREPARATION
//*********************************************************************************
// dimensions l'image z6 finale
$totalWidth = 16384;
$totalHeight = 11264;

// l'image z6 finale est trop grande pour être correctement gérée par Imagick
// de plus le tuilage est ensuite plus rapide si on travaille sur des images plus petites
// on définit donc un découpage de l'image totale, avec une marge tampon pour le recollage
// l'idéal serait d'avoir une bdd géographique pour pouvoir sélectionner uniquement les features qui sont dans la zones que nous tarvaillons.? à faire plus tard?
$nbCols = 2;		
$nbLines = 2;
$tileWidth = 256;
$nbTilesTampon = 3;
$tampon = $nbTilesTampon*$tileWidth;
$imgWidth = $totalWidth / $nbCols + $tampon;
$imgHeight = $totalHeight / $nbLines + $tampon;

// $delimitations[0] => colonne 0 ; $delimitation[0][0] => colone 0, ligne 0 : $delimitation[0][0]["minx"] etc...
// A faire : calculer les délimitations et générer le tableau en fonction du nbCols et nbLines
$delimitations = array( array( array("minx"=>0, "maxx"=>8960, "miny"=>0, "maxy"=>6400), array("minx"=>0, "maxx"=>8960, "miny"=>4864, "maxy"=>11264) ),
						array( array("minx"=>7424, "maxx"=>16384, "miny"=>0, "maxy"=>6400), array("minx"=>7424, "maxx"=>16384, "miny"=>4864, "maxy"=>11264) ));

// A faire : charger la config depuis la bdd
$layers = array(
	array("name"=>"label_pays", "type"=>"label", "style"=> array("size"=>192, "font"=>"./fonts/TrajanPro-Regular.otf", "interl"=>300, "toUpper"=>true, "strokeColor"=>"#AAAAAA", "strokeWidth"=>1, "fillColor"=>"#CCCCCC")),
//	array("name"=>"lim_fief", "type"=>"line", "style"=> array("strokeColor"=>"#8E6F58", "strokeWidth"=>4, "dashArray"=>[4,4,12,12], "strokeCap"=>"butt")),
//	array("name"=>"lim_pays", "type"=>"line", "style"=> array("strokeColor"=>"#8B0004", "strokeWidth"=>16, "dashArray"=>[48,32], "strokeCap"=>"butt")),
	array("name"=>"caravane", "type"=>"line", "style"=> array("strokeColor"=>"#6600A1", "strokeWidth"=>32, "dashArray"=>[12,12,24,24], "strokeCap"=>"butt")),
//	array("name"=>"exploration", "type"=>"picto", "style"=> array("src"=>"./img/exploration.svg")),
	array("name"=>"ville", "type"=>"cercle", "style"=> array("radius"=>24, "fillColor"=>"#8B0004")),
	array("name"=>"capitale", "type"=>"cercle", "style"=> array("radius"=>24, "fillColor"=>"#8B0004")),
	array("name"=>"label_poi", "type"=>"label", "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#000000", "strokeWidth"=>1, "fillColor"=>"#000000")),
	array("name"=>"label_riviere", "type"=>"label", "style"=> array("size"=>32, "font"=>"./fonts/Livingst.ttf", "interl"=>30, "toUpper"=>false, "strokeColor"=>"#245579", "strokeWidth"=>1, "fillColor"=>"#245579")),
	array("name"=>"label_passe", "type"=>"label", "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#8B0004", "strokeWidth"=>1, "fillColor"=>"#8B0004")),
	array("name"=>"label_fief", "type"=>"label", "style"=> array("size"=>64, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#000000", "strokeWidth"=>1, "fillColor"=>"#000000")),
	array("name"=>"label_ville", "type"=>"label", "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#000000", "strokeWidth"=>1, "fillColor"=>"#000000")),
	array("name"=>"label_capitale", "type"=>"label", "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#8B0004", "strokeWidth"=>1, "fillColor"=>"#8B0004"))
);


//**********************************************************************************
//*** DEBUT 
//**********************************************************************************
//for ($col=0; $col<$nbCols; $col++){
//	for($line=0; $line<$nbLines; $line++){
for ($col=0; $col<1; $col++){
	for($line=0; $line<1; $line++){

		$image = new \Imagick();
		$image->newImage($imgWidth, $imgHeight, new ImagickPixel('transparent'));
		$image->setImageFormat("png");
		$image->setImageFilename($col."_".$line.".png");
		echo("traitement de l'image ".$col."_".$line."............\n");
	
		$minx = $delimitations[$col][$line]["minx"];
		$maxx = $delimitations[$col][$line]["maxx"];
		$miny = $delimitations[$col][$line]["miny"];
		$maxy = $delimitations[$col][$line]["maxy"];
	
		foreach($layers as $layer) {
			echo("Layer ".$layer["name"]." : ");
			$url = 'http://localhost:8080/worldmap/features/get/'.$layer["name"];
			$content = file_get_contents($url);
			$elems = json_decode($content, true);

			$draw = createStyle($layer["type"], $layer["style"]);
			if(!$draw) {
				echo("type de couche ".$layer["type"]." non pris en charge\n");
			} else {		
				
				if($layer["type"]==="label") {
					echo("traitements des labels\n");
					foreach($elems as $elem) {
						preg_match('#\[(.+),(.+)\]#', $elem["geom"], $matches);

						$x = round(LonToPix(floatval($matches[1])));
						$y = round(LatToPix(floatval($matches[2])));
						
						// on ne traite que si le point est dans la zone de l'image
						//if ($x<=$maxx && $x>=$minx && $y<=$maxy && $y>=$miny) {
							//on split les lignes si besoin et on calcule le point d'ancrage pour Gmagick (en bas à gauche et non au centre)
							$tmp = ($layer["style"]["toUpper"]) ? mb_strtoupper($elem["texte"]) : $elem["texte"];
							$lignes = explode("#", $tmp);
							
							foreach($lignes as $ligne=>$texte) {
								$newy = $y + $ligne*$layer["style"]["interl"]; 
								$image->annotateImage($draw, $x, $newy, $elem["rotation"], $texte);							
							}			
						//}
					}
				} else if ($layer["type"]==="cercle") {
					echo("traitements des cercles\n");
					foreach($elems as $elem) {
						preg_match('#\[(.+),(.+)\]#', $elem["geom"], $matches);

						$x = round(LonToPix(floatval($matches[1])));
						$y = round(LatToPix(floatval($matches[2])));
						// on ne traite que si le point est dans la zone de l'image
						//if ($x<=$maxx && $x>=$minx && $y<=$maxy && $y>=$miny) {
							$draw->circle($x, $y, $x+$layer["style"]["radius"], $y);
							$image->drawImage($draw);				
						//}
					}
				}
			}
		}
		$findessin = microtime(true);
		echo("enregistrement de l'image...........\n");
    	$image->writeImage();
    	
    	$finenr = microtime(true);
		$dureedessin = $findessin - $debut;
		echo("durée du dessin : ".$dureedessin."\n");
		$dureeenr = $finenr - $findessin;
		echo("durée de l'enregistrement : ".$dureeenr."\n");

	}
}

/*
//************** PAYS **************    
	$draw = new \ImagickDraw();
    $draw->setStrokeColor("#AAAAAA");
    $draw->setFillColor("#CCCCCC");
    $draw->setStrokeWidth(1);
    $draw->setFontSize(192);
    $draw->setFont("./fonts/TrajanPro-Regular.otf");
    $draw->setTextAlignment(imagick::ALIGN_CENTER);
    
	// récupération du fichier json 
	$url = 'http://localhost:8080/worldmap/features/get/label_pays';
	$content = file_get_contents($url);
	$elems = json_decode($content, true);
	
	// décodage du champ geojson + conversion des coordonnées
	foreach($elems as $elem) {
		$rotation = 0;
		foreach($elem as $key=>$value) {
			if ($key === "rotation") { 
				$rotation = $elem["rotation"];
			}
		}
		foreach($elem as $key=>$value) {
			if ($key === "geom") { 
				preg_match('#\[(.+),(.+)\]#', $value, $matches);

				$x = round(LonToPix(floatval($matches[1])));
				$y = round(LatToPix(floatval($matches[2])));
				
				//on split les lignes si besoin et on calcule le point d'ancrage pour Gmagick (en bas à gauche et non au centre)
				$tmp = mb_strtoupper($elem["texte"]);
				$lignes = explode("#", $tmp);
				
				foreach($lignes as $ligne=>$texte) {
					$newy = $y + $ligne*300; // 300 étant la valeur définie comme interligne dans le style pour les pays, à rendre paramétrable
					$image->annotateImage($draw, $x, $newy, $rotation, $texte);							
				}			
			}
		}
	}

//********************** FIEFS ******************	
    $draw = new \ImagickDraw();
    $draw->setStrokeColor("#000000");
    $draw->setFillColor("#000000");
    $draw->setStrokeWidth(1);
    $draw->setFontSize(64);
    $draw->setFont("./fonts/Livingst.ttf");
    $draw->setTextAlignment(imagick::ALIGN_CENTER);
    
    // récupération du fichier json 
	$url = 'http://localhost:8080/worldmap/features/get/label_fief';
	$content = file_get_contents($url);
	$elems = json_decode($content, true);
	
	// décodage du champ geojson + conversion des coordonnées
	foreach($elems as $elem) {
		$rotation = 0;
		foreach($elem as $key=>$value) {
			if ($key === "rotation") { 
				$rotation = $elem["rotation"];
			}
		}
		foreach($elem as $key=>$value) {
			if ($key === "geom") { 
				preg_match('#\[(.+),(.+)\]#', $value, $matches);

				$x = round(LonToPix(floatval($matches[1])));
				$y = round(LatToPix(floatval($matches[2])));
				
				//on split les lignes si besoin et on calcule le point d'ancrage pour Gmagick (en bas à gauche et non au centre)
				$tmp = $elem["texte"];
				$lignes = explode("#", $tmp);
				
				foreach($lignes as $ligne=>$texte) {
					$newy = $y + $ligne*60; // 60 =valeur de l'interligne fiefs
					$image->annotateImage($draw, $x, $newy, $rotation, $texte);							
				}			
			}
		}
	}
	
	
//******************* PICTOS VILLES *********************
 	$draw = new \ImagickDraw();
    $draw->setStrokeColor("#8B0004");
    $draw->setFillColor("#8B0004");
	$rayon = 24;
	
    // récupération du fichier json 
	$url = 'http://localhost:8080/worldmap/features/get/ville';
	$content = file_get_contents($url);
	$elems = json_decode($content, true);
	
	// décodage du champ geojson + conversion des coordonnées
	foreach($elems as $elem) {
		foreach($elem as $key=>$value) {
			if ($key === "geom") { 
				preg_match('#\[(.+),(.+)\]#', $value, $matches);

				$x = round(LonToPix(floatval($matches[1])));
				$y = round(LatToPix(floatval($matches[2])));
				
				$draw->circle($x, $y, $x+$rayon, $y);
				$image->drawImage($draw);							
							
			}
		}
	}

//******************* LIMITES DE FIEFS *********************
 	$draw = new \ImagickDraw();
    $draw->setStrokeColor("#8E6F58");
    $draw->setFillColor('transparent');
    $draw->setStrokeWidth(4);
    $draw->setStrokeDashArray([4,4,12,12]);
    $draw->setStrokeLineCap(imagick::LINECAP_BUTT);

    // récupération du fichier json 
	$url = 'http://localhost:8080/worldmap/features/get/lim_fief';
	$content = file_get_contents($url);
	$elems = json_decode($content, true);
	
	// décodage du champ geojson + conversion des coordonnées
	foreach($elems as $elem) {
		$tabcoords = array();
		foreach($elem as $key=>$value) {
			if ($key === "geom") { 	
				preg_match_all('#(\[[0-9\-\.]+,[0-9\-\.]+\])#', $value, $paires);

				foreach($paires[1] as $paire) {				
					preg_match('#\[(.+),(.+)\]#', $paire, $coords);
					$x = round(LonToPix(floatval($coords[1])));
					$y = round(LatToPix(floatval($coords[2])));
					$tabcoords[] = array("x"=>$x, "y"=>$y);
				}
				
				$draw->polyline($tabcoords);
				$image->drawImage($draw);												
			}
		}
	}


*/

?>
