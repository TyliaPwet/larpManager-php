<?php 

	$image = new \Imagick();
    $image->newImage(400, 400, new ImagickPixel('black'));
    $image->setImageFormat("png");
    $image->setImageFilename("test_imagick.png");
    
    // texte 
    $draw = new \ImagickDraw();
    $draw->setStrokeColor("#AAAAAA");
    $draw->setFillColor("#000000");
    $draw->setStrokeWidth(1);
    $draw->setFontSize(24);
    $draw->setTextAlignment(imagick::ALIGN_CENTER);
   
    $image->annotateImage($draw, 200, 100, 0, "hello world!");	
   
   	// cercle rouge 
    $draw = new \ImagickDraw();
    $draw->setStrokeColor("#8B0004");
    $draw->setFillColor("#8B0004");
	$rayon = 24;
	
	$draw->circle(50, 200, 50+$rayon, 200);
	$image->drawImage($draw);							
	
	// ligne pointillés
	$draw = new \ImagickDraw();
    $draw->setStrokeColor("#8E6F58");
    $draw->setFillColor('transparent');
    $draw->setStrokeWidth(4);
    $draw->setStrokeDashArray([4,4,12,12]);

	$tabcoords = array(
		array("x"=> 20,"y"=> 300),
		array("x"=> 200,"y"=> 300),
		array("x"=> 250,"y"=> 320),
		array("x"=> 250,"y"=> 340),
		array("x"=> 350,"y"=> 300),
		array("x"=> 200,"y"=> 160)
	);
				
	$draw->polyline($tabcoords);
	$image->drawImage($draw);												
	
	$image->writeImage();
?>
