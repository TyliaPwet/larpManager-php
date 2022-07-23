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
//	array("name"=>"label_pays", "type"=>"label", "style"=> array("size"=>192, "font"=>"./fonts/TrajanPro-Regular.otf", "interl"=>300, "toUpper"=>true, "strokeColor"=>"#AAAAAA", "strokeWidth"=>1, "fillColor"=>"#CCCCCC", "rectif"=>48)),
	array("name"=>"lim_fief", "type"=>"line", "style"=> array("strokeColor"=>"#8E6F58", "strokeWidth"=>4, "dashArray"=>[4,4,12,12], "strokeCap"=>"butt")),
	array("name"=>"lim_pays", "type"=>"line", "style"=> array("strokeColor"=>"#8B0004", "strokeWidth"=>16, "dashArray"=>[48,32], "strokeCap"=>"butt")),
//	array("name"=>"caravane", "type"=>"line", "style"=> array("strokeColor"=>"#6600A1", "strokeWidth"=>32, "dashArray"=>[12,12,24,24], "strokeCap"=>"butt")),
//	array("name"=>"exploration", "type"=>"picto", "style"=> array("src"=>"./img/exploration.svg")),
//	array("name"=>"ville", "type"=>"cercle", "style"=> array("radius"=>24, "fillColor"=>/*"#8B0004"*/"#888888")),
//	array("name"=>"capitale", "type"=>"cercle", "style"=> array("radius"=>24, "fillColor"=>/*"#8B0004"*/"#888888")),
//	array("name"=>"label_poi", "type"=>"label", "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#000000", "strokeWidth"=>1, "fillColor"=>"#000000", "rectif"=>9)),
//	array("name"=>"label_riviere", "type"=>"label", "style"=> array("size"=>32, "font"=>"./fonts/Livingst.ttf", "interl"=>30, "toUpper"=>false, "strokeColor"=>"#245579", "strokeWidth"=>1, "fillColor"=>"#245579", "rectif"=>3)),
//	array("name"=>"label_passe", "type"=>"label", "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#8B0004", "strokeWidth"=>1, "fillColor"=>"#8B0004", "rectif"=>9)),
//	array("name"=>"label_fief", "type"=>"label", "style"=> array("size"=>64, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#000000", "strokeWidth"=>1, "fillColor"=>"#000000", "rectif"=>14)),
//	array("name"=>"label_ville", "type"=>"label", "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#000000", "strokeWidth"=>1, "fillColor"=>"#000000", "rectif"=>9)),
//	array("name"=>"label_capitale", "type"=>"label", "style"=> array("size"=>48, "font"=>"./fonts/Livingst.ttf", "interl"=>60, "toUpper"=>false, "strokeColor"=>"#8B0004", "strokeWidth"=>1, "fillColor"=>"#8B0004", "rectif"=>9))
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
			echo("...layer ".$layer["name"]." : ");
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

						$x = round(LonToPix($matches[1]));
						$y = round(LatToPix($matches[2]))+$layer["style"]["rectif"];
						
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
					break;
    		

				case "cercle" :
					$draw = new \ImagickDraw();
					$draw->setStrokeColor($layer["style"]["fillColor"]);
					$draw->setFillColor($layer["style"]["fillColor"]);
					
					echo("traitements des cercles\n");
					foreach($elems as $elem) {
						preg_match('#\[(.+),(.+)\]#', $elem["geom"], $matches);

						$x = round(LonToPix($matches[1]));
						$y = round(LatToPix($matches[2]));

						// on ne traite que si le point est dans la zone de l'image
						//if ($x<=$maxx && $x>=$minx && $y<=$maxy && $y>=$miny) {
							$draw->circle($x, $y, $x+$layer["style"]["radius"], $y);
							$image->drawImage($draw);				
						//}
					}
		    		break;


				case "line":
					$draw = new \ImagickDraw();
					$draw->setStrokeColor($layer["style"]["strokeColor"]);
					$draw->setFillColor('transparent'); 
					$draw->setStrokeWidth($layer["style"]["strokeWidth"]);
					$draw->setStrokeDashArray($layer["style"]["dashArray"]);
//					$draw->setStrokeLineCap(imagick::LINECAP_BUTT);

					// récupération du fichier json 
					$url = 'http://localhost:8080/worldmap/features/get/lim_fief';
					$content = file_get_contents($url);
					$elems = json_decode($content, true);
					
					// décodage du champ geojson + conversion des coordonnées
					foreach($elems as $elem) {
						$tabcoords = array();
						preg_match_all('#(\[[0-9\-\.]+,[0-9\-\.]+\])#', $elem["geom"], $paires);

						foreach($paires[1] as $paire) {				
							preg_match('#\[(.+),(.+)\]#', $paire, $coords);
							$x = round(LonToPix($coords[1]));
							$y = round(LatToPix($coords[2]));
							$tabcoords[] = array("x"=>$x, "y"=>$y);
						}
						
						$draw->polyline($tabcoords);
						$image->drawImage($draw);												
					}
					break;
				default :
					echo("type de couche ".$layer["type"]." non pris en charge\n");
					break;
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
