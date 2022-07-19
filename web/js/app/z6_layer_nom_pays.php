<?php
	$image = new \Gmagick();
    $image->newImage(16384, 11264, 'transparent', 'png');

	$draw = new \GmagickDraw();
    $draw->setStrokeColor("#AAAAAA");
    $draw->setFillColor("#CCCCCC");
    $draw->setStrokeWidth(1);
    $draw->setFontSize(192);
    $draw->setFont("./fonts/TrajanPro-Regular.otf");


// récupération du fichier json 
	$url = 'http://localhost:8080/worldmap/features/get/label_pays';
	$content = file_get_contents($url);
	
// récupération des objets du json sous forme de tableau
	$elems = json_decode($content, true);
	
// décodage du champ geojson + conversion des coordonnées
	foreach($elems as $elem) {
		foreach($elem as $key=>$value) {
			if ($key === "geom") { 
				preg_match('#\[(.+),(.+)\]#', $value, $matches);

				$x = round(LonToPix(floatval($matches[1])));
				$y = round(LatToPix(floatval($matches[2])));
				
				//on split les lignes si besoin et on calcule le point d'ancrage pour Gmagick (en bas à gauche et non au centre)
				$tmp = mb_strtoupper($elem["texte"]);
				$lignes = explode("#", $tmp);
				
				foreach($lignes as $ligne=>$texte) {
					$metrics = $image->queryfontmetrics($draw, $texte);
					$newx = $x - round($metrics["textWidth"]/2);
					$newy = $y + round($metrics["characterHeight"]/2) + $ligne*300; // 300 étant la valeur définie comme interligne dans le style pour les pays, à rendre paramétrable
					echo ("x:".$newx. " || y:".$newy." || texte:".$texte."\n");
					try {
						$image->annotateimage($draw, $newx, $newy, 0, $texte);							
					} catch (Exception $e) {
						echo 'Exception reçue : ',  $e->getMessage(), "\n";
					}
				}			
			}
		}
	}

try {
    $image->writeImage("z6_layer_nom_pays.png");
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}

function LonToPix($x) {
    $res = $x*64;
    return $res;
}

function LatToPix($y) {
	$res = -$y*64;
	return $res;
}

?>
