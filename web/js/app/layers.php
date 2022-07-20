<?php
function LonToPix($x) {
    $res = $x*64;
    return $res;
}

function LatToPix($y) {
	$res = -$y*64;
	return $res;
}


//**********************************************************************************
//*** DEBUT 
//**********************************************************************************
    $image = new \Imagick();
    $image->newImage(8960, 6400, new ImagickPixel('transparent'));
    $image->setImageFormat("png");
    $image->setImageFilename("layer.png");

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



    $image->writeImage();
?>
