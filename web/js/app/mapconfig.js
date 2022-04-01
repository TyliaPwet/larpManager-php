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
                    layerName : "labels pays",
                    source : "worldmap/json/countrieslabels",
                    geomType : "Label", // Point
                    styles : 
                        {
                            zooms : [2,3,4,5,6],
                            fontWeight: "normal", 
                            fontSize: ["12","24","46","96","192"], 
                            fontFamily: "Trebuchet",
                            interligne : 300,
                            textTransformation : "toUpper",
                            strokeColor : "#FFFFFF", 
                            strokeOpacity : 1, 
                            strokeWidth : 1,
                            fillColor : "#FFFFFF", 
                            fillOpacity : 1
                        }
                },
                {
                    layerName : "frontieres fiefs",
                    source : "worldmap/json/fiefs",
                    geomType : "Polygon", 
                    styles : {
                        zooms : [4,5,6],
                        strokeColor : "#9A785F", 
                        strokeOpacity : 1, 
                        strokeWidth : [1, 1, 1]
                    }
                },
                {
                    layerName : "frontieres pays",
                    source : "worldmap/json/countries",
                    geomType : "Polygon", 
                    styles : {
                        zooms : [2,3,4,5,6],
                        strokeColor : "#8B0004", 
                        strokeOpacity : 1, 
                        strokeWidth : [2,3,4,4,4]
                    }
                },
                {
                    layerName : "labels fiefs",
                    source : "worldmap/json/fiefslabels",
                    geomType : "Label", // Point
                    styles:{
                        zooms : [4,5,6],
                    	fontWeight: "normal", 
                        fontSize: ["18","36","72"], 
                        fontFamily: "Fiefs",
                        interligne : 74,
                        textTransformation : "none",
                        strokeColor : "#000000", 
                        strokeOpacity : 1, 
                        strokeWidth : 1,
                        fillColor : "#000000", 
                        fillOpacity : 1
                    }
                },
                {
                    layerName : "villes",
                    source : "worldmap/json/pictos/ville",
                    geomType : "Point", 
                    styles : {
                        zooms : [4,5,6],
                        pointRadius : [5,10,20],
                        fillColor : "#8B0004", 
                        fillOpacity : 1
                    }
                },
                {
                    layerName : "caravane",
                    source : "worldmap/json/lignes/caravane",
                    geomType : "Line", 
                    styles : {
                        zooms : [4,5,6],
                        strokeColor: "#6600A1", 
                        strokeOpacity: 1, 
                        strokeWidth: [8,16,32], 
                        strokeDashArray: [[3,3,6,6], [6,6,12,12], [12,12,24,24]],
                        strokeCap : "butt"
                    }
                }
            ]
        },
        {
            name : "magnaCarta",
            minZoom : 2,
            maxZoom : 6,
            printZoom : 6,
            useBackground : true,
            layers : []
        }
    ]

};

// On définit des styles par défaut pour tous les nouveaux objets && les objets dont le style serait incomplet ou non trouvé (en cas de lecture depuis la bdd)
// Ce tableau nous sert aussi de référence pour toutes les propriétés possibles selon le type de géométrie
// On ne tiendra pas compte d'éventuelles autres propriétés déclarées
// Attention il faut définir des tableaux de taille pour les largeurs de lignes et hauteurs de polices

var defaultStyleProperties = {
		zooms: [2,3,4,5,6],
		
		// Lignes (et contours polygones)
		strokeColor: "#FF6C00", // orange pour bien distinguer les nouveautés || erreurs de config
		strokeOpacity: 1,
		strokeWidth: [2,4,8,16,32,64],
		strokeDashstyle: "solid",
		strokeCap: "butt",

		// Couleur de fond par défaut
		fillColor: "#FF6C00",
		fillOpacity: 0.5,

		// Labels
		texte: "Text",
		fontFamily: "Arial, Hevetica, sans-serif",
		fontSize: [4,8,16,32,64],
		fontWeight : "normal",
		interligne: 80,
		textTransformation: "none",
		textAlign: "center", 
		
		// Points
		pointRadius: [2,4,8,16,32,64],
		imgSrc: "cercle",
		imgHeight: [10,20,40,80,160],
		imgWidth: [10,20,40,80,160],
		
		rotation: 0
	};

