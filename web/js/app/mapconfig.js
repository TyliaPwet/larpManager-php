var Mapconfig = {
    background : {   // infos pour la carte image en fond
        tilesX : 64,
        tilesY : 44,
        tileSize : 256,
        mapUrl : 'img/map_clean'
    },
    
    maps : [
        {
            name : "baseMap",
            minZoom : 2,
            maxZoom : 4,
            printZoom : 2,
            useBackground : true,
            layers : [
                // les layers sont rangées de la plus au fond à la plus en surface
                // -----------------
                // on pourrait tout mettre dans la même layer avec juste un zIndex différent mais cela risque de poser des soucis plus tard pour les modifications / dessin
                // car il pourrait y avoir plusieurs features qui se superposent et ça ne serait pas très ergonnomique de devoir chercher la bonne en cliquant...
                // ce sera plus simple de pouvoir masquer les couches qu'onn ne veut pas modifier, ou au moins les rendre non sélectionnables
                // -----------------
                // ******* il faudra lister les valeurs "fixes "utilisées" pour une aide à la création de nouvelles couches pour faire une "aide"
                // ******* lors d'un prochain dev, il faudra que ce paramétrage puisse être stocké en base et modifié directement par les orgas sous larpmanager
                {
                    layerName : "label pays",
                    source : "worldmap/json/countrieslabels",
                    geomType : "Label", // Point
                    styles : 
                        {
                            zooms : [2,3,4],
                            text : {font : ["normal 12px Pays","normal 26px Pays", "normal 48px Pays"] , 
                                    field : "texte", 
                                    transformation : "toUpper"},
                            stroke : {color : "CCCCCC", opacity : 1, width : 1},
                            fill : {color : "CCCCCC", opacity : 1},
                        }
                },
                {
                    layerName : "frontieres fiefs",
                    source : "worldmap/json/fiefs",
                    geomType : "Polygon", 
                    styles : {
                        zooms : [3,4],
                        stroke : {color : "#B98B54", opacity : 1, width : [1, 1, 1]}
                    }
                },
                {
                    layerName : "label fiefs",
                    source : "worldmap/json/fiefslabels",
                    geomType : "Label", // Point
                    styles:{
                        zooms : [3,4],
                        text : {font : ["normal 12px Fiefs", "normal 20px Fiefs"], 
                                field : "texte", 
                                transformation : "none"},
                        stroke : {color : "000000", opacity : 1, width : 1},
                        fill : {color : "000000", opacity : 1},
                    }
                },
                {
                    layerName : "frontieres pays",
                    source : "worldmap/json/countries",
                    geomType : "Polygon", 
                    styles : {
                        zooms : [2,3,4],
                        stroke : {color : "8B0004", opacity : 1, width : [2, 3, 4]}
                    }
                }
                
            ]
        },
        {
            name : "magnaCarta",
            minZoom : 0,
            maxZoom : 6,
            printZoom : 0,
            useBackground : true,
            layers : []

        }
    ]

};
