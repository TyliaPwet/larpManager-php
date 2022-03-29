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
            maxZoom : 6,
            printZoom : 2,
            useBackground : true,
            layers : [
                // les layers sont rangées de la plus au fond à la plus en surface
                // -----------------
                // on pourrait tout mettre dans la même layer avec juste un zIndex différent mais on anticipe sur un futur gestionnaire d'affichage des layers
                // de plus c'est plus pratique pour gérer les modifications / sécuriser les modifs et suppressions car on n'agit que sur 1 couche à la fois
                // -----------------
                // ******* il faudra lister les valeurs "fixes "utilisées" pour une aide à la création de nouvelles couches pour faire une "aide"
                // ******* lors d'un prochain dev, il faudra que ce paramétrage puisse être stocké en base et modifié directement par les orgas sous larpmanager
                {
                    layerName : "label pays",
                    source : "worldmap/json/countrieslabels",
                    geomType : "Label", // Point
                    styles : 
                        {
                            zooms : [2,3,4,5,6],
                            text : {font : [
                                        {style: "normal", size: "12", font: "Pays"},
                                        {style: "normal", size: "24", font: "Pays"}, 
                                        {style: "normal", size: "48", font: "Pays"}, 
                                        {style: "normal", size: "96", font: "Pays"},
                                        {style: "normal", size: "190", font: "Pays"}],
                                    interligne : 300,
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
                        zooms : [4,5,6],
                        stroke : {color : "#B98B54", opacity : 1, width : [1, 1, 1]}
                    }
                },
                {
                    layerName : "frontieres pays",
                    source : "worldmap/json/countries",
                    geomType : "Polygon", 
                    styles : {
                        zooms : [2,3,4,5,6],
                        stroke : {color : "8B0004", opacity : 1, width : [2,3,4,5,6]}
                    }
                },
                {
                    layerName : "label fiefs",
                    source : "worldmap/json/fiefslabels",
                    geomType : "Label", // Point
                    styles:{
                        zooms : [4,5,6],
                        text : {font : [
                                    {style: "normal", size: "16", font: "Fiefs"},
                                    {style: "normal", size: "32", font: "Fiefs"},
                                    {style: "normal", size: "64", font: "Fiefs"}],
                                interligne : 84,
                                field : "texte", 
                                transformation : "none"},
                        stroke : {color : "000000", opacity : 1, width : 1},
                        fill : {color : "000000", opacity : 1},
                    }
                }
                
                
            ]
        },
        {
            name : "fiefsSeuls",
            minZoom : 2,
            maxZoom : 6,
            printZoom : 4,
            useBackground : true,
            layers : [
                {
                    layerName : "frontieres fiefs",
                    source : "worldmap/json/fiefs",
                    geomType : "Polygon", 
                    styles : {
                        zooms : [3,4,5,6],
                        stroke : {color : "#FF0000", opacity : 1, width : [1, 1, 1]}
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
