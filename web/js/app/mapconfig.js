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
                // ******* A faire : stocker ce paramétrage en base et faire les écrans de gestion associés
                {
                    layerName : "labels pays",
                    source : "worldmap/features/get/label_pays",
                    geomType : "Label", // Point
                    style : {
                    	zooms: [2,3,4,5,6],
                    	styles: "titre1"
                	},
		            geomInteractions : {
		            	translate : true,	// déplacer le point d'ancrage
		            	modify : true		// modifier le texte
	            	}
                },
                {
                    layerName : "frontieres fiefs",
                    source : "worldmap/features/get/fief",
                    geomType : "Polygon", 
                    style : {
                    	zooms: [3,4,5,6],
                    	styles: "ligne2"
                	},
                	geomInteractions : {
		            	translate : false,	// déplacer l'ensemble du polygone
	            		modify : true		// modifier les points du polygone
	            	}
                },
                {
                    layerName : "frontieres pays",
                    source : "worldmap/features/get/pays",
                    geomType : "Polygon", 
                    style : {
                        zooms : [2,3,4,5,6],
                        styles: "ligne1"
                    },
                    geomInteractions : {
		                translate : false,
		                modify : false
	                }
                },
                {
                    layerName : "labels fiefs",
                    source : "worldmap/features/get/label_fief",
                    geomType : "Label", // Point
                    style: {
                        zooms : [4,5,6],
                        styles: "texte1"
                    },
                    geomInteractions : {
                    	translate : true,
                    	modify : true
                	}
                },
                {
                    layerName : "villes",
					source : "worldmap/features/get/ville", 
                    geomType : "Point", 
                    style : {
                        zooms : [4,5,6],
                        styles: "cercle1"
                    },
                    geomInteractions : {
                    	translate : true,	// déplacer le point d'ancrage
                    	modify : false		// n'a pas de sens pour le moment, identique à translate
                	}
                },
                {
                    layerName : "caravane",
					source : "worldmap/features/get/caravane",
                    geomType : "Line", 
                    style : {
                        zooms : [4,5,6],
                        styles: "ligne3"
                    },
                    geomInteractions : {
                    	translate : false,	// déplacer l'ensemble du tracé...
                    	modify : true		// modifier les points du tracé
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


// Ici on définit les styles possibles, pour tous les zooms possibles
// Il n'est pas dit que tous les niveaux de zooms seront utilisés pour toutes les cartes
// A faire : gestion d'erreur en cas d'appel à un niveau de zoom non défini ici
// A faire : mettre tout ça en base de données
var bddStyles = {
	"titre1" : {
        zooms : [2,3,4,5,6],
        fontWeight: "normal", 
        fontSize: ["12","24","46","96","192"], 
        fontFamily: "Pays",
        interligne : 300,
        textTransformation : "toUpper",
        strokeColor : "#FFFFFF", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#FFFFFF", 
        fillOpacity : 1		
	},
	"texte1" : {
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
	},
	"ligne1" : {
        zooms : [2,3,4,5,6],
        strokeColor : "#8B0004", 
        strokeOpacity : 1, 
        strokeWidth : [2,3,4,4,4]
	},
	"ligne2" : {
        zooms : [2,3,4,5,6],
        strokeColor : "#9A785F", 
        strokeOpacity : 1, 
        strokeWidth : [1,1,1, 1, 1]
    },
    "ligne3" : {
        zooms : [4,5,6],
        strokeColor: "#6600A1", 
        strokeOpacity: 1, 
        strokeWidth: [8,16,32], 
        strokeDashArray: [[3,3,6,6], [6,6,12,12], [12,12,24,24]],
        strokeCap : "butt"
    },
    "cercle1" : {
        zooms : [2,3,4,5,6],
        pointRadius : [1,2,5,10,20],
        fillColor : "#8B0004", 
        fillOpacity : 1,
        imgSrc: 'cercle'
    }
    
	
	
}

// On définit quelles propriétés sont attendues selon le type d'objets à afficher
// pas utilisé pour l'instant
var allowedStyleProperties = {
    "Label": [ 
    	"zooms", "texte",
        "fontColor", "fontFamily", "fontWeight", "fontSize",
         "strokeColor", "strokeOpacity", "strokeWidth",
         "fillColor", "fillOpacity",
         "interligne"
    ],
    "Point": [
    	"zooms",
        "fillColor", "fillOpacity", 
        "imgSrc", "imgHeight", "imgWidth", 
        "pointRadius", "rotation"
    ],
    "Line": [
    	"zooms",
		"strokeColor", "strokeOpacity", "strokeWidth",
		"strokeDashstyle", "strokeCap"
    ],
    "Polygon": [
    	"zooms",
        "strokeColor", "strokeOpacity", "strokeWidth",
        "fillColor", "fillOpacity"            
    ]
};

