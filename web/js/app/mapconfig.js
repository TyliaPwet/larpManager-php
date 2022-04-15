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
            printZoom : 6,
            useBackground : true,
            layers : [
                // les layers sont rangées de la plus au fond à la plus en surface
                // -----------------
                // ******* A faire : stocker ce paramétrage en base et faire les écrans de gestion associés
                // la layerName = la categorie d'objet (comme dans la bdd)
                {
                    layerName : "label_pays",
                    source : "worldmap/features/get/label_pays",
                    geomType : "Label", // Point
                    style : {
                    	zooms: [2,3,4,5,6],
                    	styleName: "titre1"
                	},
		            geomInteractions : {
		            	translate : true,	// déplacer le point d'ancrage
		            	modify : true		// modifier le texte
	            	}
                },
                {
                    layerName : "fief",
                    source : "worldmap/features/get/fief",
                    geomType : "Polygon", 
                    style : {
                    	zooms: [3,4,5,6],
                    	styleName: "ligne2"
                	},
                	geomInteractions : {
		            	translate : false,	// déplacer l'ensemble du polygone
	            		modify : true		// modifier les points du polygone
	            	}
                },
                {
                    layerName : "pays",
                    source : "worldmap/features/get/pays",
                    geomType : "Polygon", 
                    style : {
                        zooms : [2,3,4,5,6],
                        styleName: "ligne1"
                    },
                    geomInteractions : {
		                translate : false,
		                modify : false
	                }
                },
                {
                    layerName : "label_fief",
                    source : "worldmap/features/get/label_fief",
                    geomType : "Label", // Point
                    style: {
                        zooms : [4,5,6],
                        styleName: "texte1"
                    },
                    geomInteractions : {
                    	translate : true,
                    	modify : true
                	}
                },
                {
                    layerName : "ville",
					source : "worldmap/features/get/ville", 
                    geomType : "Point", 
                    style : {
                        zooms : [4,5,6],
                        styleName: "cercle1"
                    },
                    geomInteractions : {
                    	translate : true,	// déplacer le point d'ancrage
                    	modify : false		// n'a pas de sens pour un point, identique à translate
                	}
                },
                {
                    layerName : "caravane",
					source : "worldmap/features/get/caravane",
                    geomType : "LineString", 
                    style : {
                        zooms : [4,5,6],
                        styleName: "ligne3"
                    },
                    geomInteractions : {
                    	translate : false,	// déplacer l'ensemble du tracé...
                    	modify : true		// modifier les points du tracé
                    }
                },
                {
                    layerName : "exploration",
					source : "worldmap/features/get/exploration", 
                    geomType : "Point", 
                    style : {
                        zooms : [2,3,4,5,6],
                        styleName: "exploration"
                    },
                    geomInteractions : {
                    	translate : true,	// déplacer le point d'ancrage
                    	modify : false		// n'a pas de sens pour un point, identique à translate
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
            layers : [
            	{
                    layerName : "label_pays",
                    source : "worldmap/features/get/label_pays",
                    geomType : "Label", // Point
                    style : {
                    	zooms: [2,3,4,5,6],
                    	styleName: "titre1"
                	},
		            geomInteractions : {
		            	translate : true,	// déplacer le point d'ancrage
		            	modify : true		// modifier le texte
	            	}
                },
                {
                    layerName : "fief",
                    source : "worldmap/features/get/fief",
                    geomType : "Polygon", 
                    style : {
                    	zooms: [3,4,5,6],
                    	styleName: "ligne2"
                	},
                	geomInteractions : {
		            	translate : false,	// déplacer l'ensemble du polygone
	            		modify : true		// modifier les points du polygone
	            	}
                },
                {
                    layerName : "pays",
                    source : "worldmap/features/get/pays",
                    geomType : "Polygon", 
                    style : {
                        zooms : [2,3,4,5,6],
                        styleName: "ligne1"
                    },
                    geomInteractions : {
		                translate : false,
		                modify : false
	                }
                },
                {
                    layerName : "label_fief",
                    source : "worldmap/features/get/label_fief",
                    geomType : "Label", // Point
                    style: {
                        zooms : [4,5,6],
                        styleName: "texte2"
                    },
                    geomInteractions : {
                    	translate : true,
                    	modify : true
                	}
                },
                {
                    layerName : "caravane",
					source : "worldmap/features/get/caravane",
                    geomType : "LineString", 
                    style : {
                        zooms : [4,5,6],
                        styleName: "ligne3"
                    },
                    geomInteractions : {
                    	translate : false,	// déplacer l'ensemble du tracé...
                    	modify : true		// modifier les points du tracé
                    }
                },
                {
                    layerName : "exploration",
					source : "worldmap/features/get/exploration", 
                    geomType : "Point", 
                    style : {
                        zooms : [2,3,4,5,6],
                        styleName: "exploration"
                    },
                    geomInteractions : {
                    	translate : true,	// déplacer le point d'ancrage
                    	modify : false		// n'a pas de sens pour un point, identique à translate
                	}
                }
            
            ]
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
		//strokeDashStyle: "solid",
		strokeCap: "butt",

		// Couleur de fond par défaut
		fillColor: "#FF6C00",
		fillOpacity: 1,

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
        fontFamily: "Trebuchet",
        interligne : 300,
        textTransformation : "toUpper",
        strokeColor : "#FFFFFF", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#FFFFFF", 
        fillOpacity : 1		
	},
	"texte1" : {
		zooms : [2,3,4,5,6],
    	fontWeight: "normal", 
        fontSize: ["4","9","18","36","72"], 
        fontFamily: "Fiefs",
        interligne : 60,
        textTransformation : "none",
        strokeColor : "#000000", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#000000", 
        fillOpacity : 1
	},
	"texte2" : {
		zooms : [2,3,4,5,6],
    	fontWeight: "normal", 
        fontSize: ["2","4","8","16","32"], 
        fontFamily: "Fiefs",
        interligne : 30,
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
        strokeWidth : [2,2,2,3,3]
	},
	"ligne2" : {
        zooms : [2,3,4,5,6],
        strokeColor : "#9A785F", 
        strokeOpacity : 1, 
        strokeWidth : [1,1,1,1,1],
        strokeDashArray: [[3,3],[3,3],[3,3],[3,3],[3,3]],
        strokeCap: "butt"
    },
    "ligne3" : {
        zooms : [2,3,4,5,6],
        strokeColor: "#6600A1", 
        strokeOpacity: 1, 
        strokeWidth: [2,4,8,16,32], 
        strokeDashArray: [[1,1,3,3],[1,1,3,3],[3,3,6,6], [6,6,12,12], [12,12,24,24]],
        strokeCap : "butt"
    },
    "cercle1" : {
        zooms : [2,3,4,5,6],
        pointRadius : [1,2,5,10,20],
        fillColor : "#8B0004", 
        fillOpacity : 1,
        imgSrc: 'cercle'
    },
    "cercle2" : {
        zooms : [2,3,4,5,6],
        pointRadius : [1,2,4,8,16],
        fillColor : "#8B0004", 
        fillOpacity : 1,
        imgSrc: 'cercle'
    },
    "exploration": {
        zooms : [2,3,4,5,6],
        pointRadius : [3,6,10,14,24],
        fillColor : "#00FF00", 
        fillOpacity : 1,
        imgSrc: 'img/pictos/exploration.svg',
        scale: [0.5,1,2,4,8]
    },
    "capitale": {
        zooms : [2,3,4,5,6],
        pointRadius : [3,6,10,14,24],
        fillColor : "#0000FF", 
        fillOpacity : 1,
        imgSrc: 'cercle'
    }
}

