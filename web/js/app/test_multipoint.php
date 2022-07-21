<?php

function LonToPix($x) {
    $res = $x*64;
    return $res;
}

function LatToPix($y) {
	$res = -$y*64;
	return $res;
}

    $image = new \Imagick();
    $image->newImage(5000, 1000, new ImagickPixel('transparent'));
    $image->setImageFormat("png");

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
	$elem = $elems[0];
	$tabcoords = array();
	foreach($elem as $key=>$value) {
		if ($key === "geom") { 	
//			preg_match('#^\[\[(.+),(.+)\]\]$#', $value, $paires);
			preg_match_all('#(\[[0-9\-\.]+,[0-9\-\.]+\])#', $value, $paires);

			foreach($paires[1] as $paire) {				
				preg_match('#\[(.+),(.+)\]#', $paire, $coords);
				$x = round(LonToPix(floatval($coords[1])));
				$y = round(LatToPix(floatval($coords[2])));
				echo("x: ".$x." ,y: ".$y."\n");
				$tabcoords[] = array("x"=>$x, "y"=>$y);
			}
			foreach($tabcoords as $tabcoord){
				echo("x: ".$tabcoord["x"]." ,y: ".$tabcoord["y"]."\n");
			}
//			var_dump($tabcoords);
		}
	}
	

    $draw->polyline($tabcoords);
	$image->drawImage($draw);	

    $image->setImageFilename("polyline.png");
    $image->writeImage();
   
    
/*foreach($elems as $elem) {
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
