<?php
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
	array("name"=>"label_pays", "type"=>"label", "zoom"=>[2,3,4,5,6], "style"=> array("size"=>192, "font"=>"./fonts/TrajanPro-Regular.otf", "interl"=>300, "toUpper"=>true, "strokeColor"=>"#AAAAAA", "strokeWidth"=>1, "fillColor"=>"#CCCCCC", "rectif"=>48)),
	array("name"=>"lim_fief", "type"=>"line", "zoom"=>[3,4,5,6], "style"=> array("strokeColor"=>"#8E6F58", "strokeWidth"=>[2,2,4,4], "dashArray"=>[[2,2,6,6],[2,2,6,6], [4,4,12,12], [4,4,12,12]], "strokeCap"=>"butt")),
	array("name"=>"lim_pays", "type"=>"line", "zoom"=>[2,3,4,5,6], "style"=> array("strokeColor"=>"#8B0004", "strokeWidth"=>[2,3,4,8,16], "dashArray"=>[[6,4],[8,6],[12,8],[24,16],[48,32]], "strokeCap"=>"butt")),
	array("name"=>"caravane", "type"=>"line", "zoom"=>[3,4,5,6], "style"=> array("strokeColor"=>"#6600A1", "strokeWidth"=>[4,8,16,32], "dashArray"=>[[1,1,3,3],[3,3,6,6], [6,6,12,12], [12,12,24,24]], "strokeCap"=>"butt")),
	array("name"=>"exploration", "type"=>"picto", "zoom"=>[3,4,5,6], "style"=> array("src"=>"./img/exploration_gd.png")),
	array("name"=>"ville", "type"=>"cercle", "zoom"=>[4,5,6], "style"=> array("radius"=>24, "fillColor"=>"#8B0004")),
	array("name"=>"capitale", "type"=>"cercle", "zoom"=>[3,4,5,6], "style"=> array("radius"=>24, "fillColor"=>"#8B0004")),
	array("name"=>"label_poi", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>40, "toUpper"=>false, "strokeColor"=>"#000000", "strokeWidth"=>1, "fillColor"=>"#555555", "rectif"=>9)),
	array("name"=>"label_riviere", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>32, "font"=>"./fonts/Livingst.ttf", "interl"=>30, "toUpper"=>false, "strokeColor"=>"#245579", "strokeWidth"=>1, "fillColor"=>"#245579", "rectif"=>3)),
	array("name"=>"label_passe", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>40, "toUpper"=>false, "strokeColor"=>"#8B0004", "strokeWidth"=>1, "fillColor"=>"#8B0004", "rectif"=>9)),
	array("name"=>"label_fief", "type"=>"label", "zoom"=>[3,4,5,6], "style"=> array("size"=>64, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#000000", "strokeWidth"=>1, "fillColor"=>"#000000", "rectif"=>14)),
	array("name"=>"label_ville", "type"=>"label", "zoom"=>[4,5,6], "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>40, "toUpper"=>false, "strokeColor"=>"#000000", "strokeWidth"=>1, "fillColor"=>"#555555", "rectif"=>9)),
	array("name"=>"label_capitale", "type"=>"label", "zoom"=>[3,4,5,6], "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>40, "toUpper"=>false, "strokeColor"=>"#8B0004", "strokeWidth"=>1, "fillColor"=>"#8B0004", "rectif"=>9))
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
$debut = microtime(true);

// pour les zooms 2 à 5, on a une seule image en sortie
//for($z=$minZoom; $z<$maxZoom; $z++) {
for($z=3; $z<6; $z++) {
	$divFactor = pow($zoomFactor, $maxZoom-$z);
	$imgWidth = $mapWidth / $divFactor;
	$imgHeight = $mapHeight / $divFactor;
	
	$image = new \Imagick();
	$image->newImage($imgWidth, $imgHeight, new ImagickPixel('transparent'));
	$image->setImageFormat("png");
	$image->setImageFilename("z".$z.".png");

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
				$draw->setStrokeWidth($layer["style"]["strokeWidth"][$i]);
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
	
	
	
	$findessin = microtime(true);
	echo("enregistrement de l'image ...........\n");
	$image->writeImage();
	
	$finenr = microtime(true);
	$dureedessin = $findessin - $debut;
	echo("durée du dessin : ".$dureedessin."\n");
	$dureeenr = $finenr - $findessin;
	echo("durée de l'enregistrement : ".$dureeenr."\n");
	echo(".................................................\n");
}


?>
