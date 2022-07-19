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
                    layerName : "lim_fief",
                    source : "worldmap/features/get/lim_fief",
                    geomType : "LineString", 
                    style : {
                    	zooms: [4,5,6],
                    	styleName: "ligne5"
                	},
                	geomInteractions : {
		            	translate : false,	
	            		modify : true		
	            	}
                },
                {
                    layerName : "lim_pays",
                    source : "worldmap/features/get/lim_pays",
                    geomType : "LineString", 
                    style : {
                        zooms : [2,3,4,5,6],
                        styleName: "ligne6"
                    },
                    geomInteractions : {
		                translate : false,
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
                    layerName : "capitale",
					source : "worldmap/features/get/capitale", 
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
                    layerName : "label_poi",
                    source : "worldmap/features/get/label_poi",
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
                    layerName : "label_riviere",
                    source : "worldmap/features/get/label_riviere",
                    geomType : "Label", // Point
                    style: {
                        zooms : [4,5,6],
                        styleName: "texte3bleu"
                    },
                    geomInteractions : {
                    	translate : true,
                    	modify : true
                	}
                },
                {
                    layerName : "label_passe",
                    source : "worldmap/features/get/label_passe",
                    geomType : "Label", // Point
                    style: {
                        zooms : [4,5,6],
                        styleName: "texte2rouge"
                    },
                    geomInteractions : {
                    	translate : true,
                    	modify : true
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
                    layerName : "label_ville",
                    source : "worldmap/features/get/label_ville",
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
                    layerName : "label_capitale",
                    source : "worldmap/features/get/label_capitale",
                    geomType : "Label", // Point
                    style: {
                        zooms : [4,5,6],
                        styleName: "texte2rouge"
                    },
                    geomInteractions : {
                    	translate : true,
                    	modify : true
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
            		layerName: "zonedeau",
            		source: "worldmap/features/get/zonedeau",
            		geomType: "Polygon",
            		style: {
            			zooms: [2,3,4,5,6],
            			styleName: "surf1bleu"
        			},
        			geomInteractions : {
        				translate : false,
        				modify : true
    				}
				},
				{
                    layerName : "riviere",
					source : "worldmap/features/get/riviere",
                    geomType : "LineString", 
                    style : {
                        zooms : [2,3,4,5,6],
                        styleName: "ligne4"
                    },
                    geomInteractions : {
                    	translate : false,	
                    	modify : true		// modifier les points du tracé
                    }
                },
				{
                    layerName : "label_sea",
                    source : "worldmap/features/get/label_sea",
                    geomType : "Label", // Point
                    style : {
                    	zooms: [2,3,4,5,6],
                    	styleName: "titre2"
                	},
		            geomInteractions : {
		            	translate : true,	
		            	modify : true
	            	}
                },
                {
                    layerName : "lim_sea",
                    source : "worldmap/features/get/lim_sea",
                    geomType : "LineString", 
                    style : {
                    	zooms: [2,3,4,5,6],
                    	styleName: "ligne7"
                	},
                	geomInteractions : {
		            	translate : false,	
	            		modify : true		
	            	}
                },
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
                    layerName : "lim_fief",
                    source : "worldmap/features/get/lim_fief",
                    geomType : "LineString", 
                    style : {
                    	zooms: [4,5,6],
                    	styleName: "ligne5"
                	},
                	geomInteractions : {
		            	translate : false,	
	            		modify : true		
	            	}
                },
                {
                    layerName : "lim_pays",
                    source : "worldmap/features/get/lim_pays",
                    geomType : "LineString", 
                    style : {
                        zooms : [2,3,4,5,6],
                        styleName: "ligne6"
                    },
                    geomInteractions : {
		                translate : false,
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
                },
            	{
                    layerName : "label_magna",
                    source : "worldmap/features/get/label_magna",
                    geomType : "Label", // Point
                    style: {
                        zooms : [4,5,6],
                        styleName: "texte2"//"texte3"
                    },
                    geomInteractions : {
                    	translate : true,
                    	modify : true
                	}
                },
                {
                	layerName : "ressource",
                	source : "worldmap/features/get/ressource",
                	geomType : "Point",
                	style : {
                		zooms : [4,5,6],
                		styleName: "etoile"
                	},
                	geomInteractions : {
                		translate : true,
                		modify : false
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

var DefaultStyleProperties = {
		zooms: [2,3,4,5,6],
		
		// Lignes (et contours polygones)
		strokeColor: "#FF6C00", // orange pour bien distinguer les nouveautés || erreurs de config
		strokeOpacity: 1,
		strokeWidth: [1,1,1,1,1], //[2,4,4,4,4],
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
		pointRadius: [2,4,6,12,24],
		imgSrc: "cercle",
		imgHeight: [10,20,40,80,160],
		imgWidth: [10,20,40,80,160],
		
		rotation: 0
	};


// Ici on définit les styles possibles, pour tous les zooms possibles
// Il n'est pas dit que tous les niveaux de zooms seront utilisés pour toutes les cartes
// A faire : gestion d'erreur en cas d'appel à un niveau de zoom non défini ici
// A faire : mettre tout ça en base de données
var BddStyles = {
	"titre1" : { // noms de pays fond clair
        zooms : [2,3,4,5,6],
        fontWeight: "normal", 
        fontSize: ["12","24","46","96","192"], 
        fontFamily: "Pays",//"Trebuchet",
        interligne : 300,
        textTransformation : "toUpper",
        strokeColor : "#AAAAAA", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#CCCCCC", 
        fillOpacity : 1		
	},
	"titre1gris" : { // noms de pays fond foncé
        zooms : [2,3,4,5,6],
        fontWeight: "normal", 
        fontSize: ["12","24","46","96","192"], 
        fontFamily: "Pays",//"Trebuchet",
        interligne : 300,
        textTransformation : "toUpper",
        strokeColor : "#AAAAAA", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#555555", 
        fillOpacity : 1		
	},
	"titre2" : { // noms de pays fond foncé
        zooms : [2,3,4,5,6],
        fontWeight: "normal", 
        fontSize: ["7","14","28","56","112"], 
        fontFamily: "Fiefs",//"Trebuchet",
        interligne : 150,
        textTransformation : "toUpper",
        strokeColor : "#FFFFFF", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#FFFFFF", 
        fillOpacity : 1		
	},
	"texte1" : { // noms fiefs
		zooms : [2,3,4,5,6],
    	fontWeight: "normal", 
        //fontSize: ["6","12","24","48","96"],
        fontSize: ["4","8","16","32","64"],  
        fontFamily: "Fiefs",
        interligne : 60,
        textTransformation : "none",
        strokeColor : "#000000", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#000000", 
        fillOpacity : 1
	},
	"texte2" : { // nom villes
		zooms : [2,3,4,5,6],
    	fontWeight: "normal", 
        fontSize: ["3","6","12","24","48"], 
        fontFamily: "Fiefs",
        interligne : 60,
        textTransformation : "none",
        strokeColor : "#000000", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#000000", 
        fillOpacity : 1
	},
	"texte2rouge" : { // noms capitales
		zooms : [2,3,4,5,6],
    	fontWeight: "normal", 
        fontSize: ["3","6","12","24","48"], 
        fontFamily: "Fiefs",
        interligne : 60,
        textTransformation : "none",
        strokeColor : "#8B0004", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#8B0004", 
        fillOpacity : 1
	},
	"texte3" : {
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
	"texte3bleu" : { // nom cours d'eau
		zooms : [2,3,4,5,6],
    	fontWeight: "normal", 
        fontSize: ["2","4","8","16","32"], 
        fontFamily: "Fiefs",
        interligne : 30,
        textTransformation : "none",
        strokeColor : "#245579", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#245579", 
        fillOpacity : 1
	},
	"texte3rouge" : { 
		zooms : [2,3,4,5,6],
    	fontWeight: "normal", 
        fontSize: ["2","4","8","16","32"], 
        fontFamily: "Fiefs",
        interligne : 30,
        textTransformation : "none",
        strokeColor : "#8B0004", 
        strokeOpacity : 1, 
        strokeWidth : 1,
        fillColor : "#8B0004", 
        fillOpacity : 1
	},
	"ligne1" : { // contour polygone pays : ligne continue rouge
        zooms : [2,3,4,5,6],
        strokeColor : "#8B0004", 
        strokeOpacity : 1, 
        strokeWidth : [2,2,2,3,3]
	},
	"ligne2" : { // controur polygone fief : ligne pointillée sable
        zooms : [2,3,4,5,6],
        strokeColor : "#8E6F58",
        strokeOpacity : 1, 
        strokeWidth : [1,1,1,1,1],
        strokeDashArray: [[3,3],[3,3],[3,3],[3,3],[3,3]],
        strokeCap: "butt"
    },
    "ligne3" : { // caravane
        zooms : [2,3,4,5,6],
        strokeColor: "#6600A1", 
        strokeOpacity: 1, 
        strokeWidth: [2,4,8,16,32], 
        strokeDashArray: [[1,1,3,3],[1,1,3,3],[3,3,6,6], [6,6,12,12], [12,12,24,24]],
        strokeCap : "butt"
    },
    "ligne4" : { // riviere
        zooms : [2,3,4,5,6],
        strokeColor: "#0080FF", 
        strokeOpacity: 0.5, 
        strokeWidth: [4,8,16,32,64], 
        strokeCap : "butt"
    },
    "ligne6" : { // frontiere pays : ligne pointillée rouge
        zooms : [2,3,4,5,6],
        strokeColor : "#8B0004",//"#8B0004",
        strokeOpacity : 1, 
        strokeWidth : [2,3,4,8,16],
        strokeDashArray: [[6,4],[8,6],[12,8],[24,16],[48,32]],
        strokeCap: "butt"
    },
    "ligne5" : { // frontière fief : ligne pointillée sable
        zooms : [2,3,4,5,6],
        strokeColor : "#8E6F58", 
        strokeOpacity : 1, 
        strokeWidth : [1,2,2,4,4],
        strokeDashArray: [[1,1,3,3],[2,2,6,6],[2,2,6,6], [4,4,12,12], [4,4,12,12]],
        strokeCap: "butt"
    },
    "ligne7" : { // limite zone maritime
        zooms : [2,3,4,5,6],
        strokeColor : "#FFFFFF",
        strokeOpacity : 1, 
        strokeWidth : [1,2,2,4,4],
        strokeDashArray: [[3,3],[6,6],[6,6],[12,12],[12,12]],
        strokeCap: "butt"
    },
    "cercle1" : {
        zooms : [2,3,4,5,6],
        pointRadius : [2,4,6,12,24],
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
    },
    "surf1bleu" : { // mer
        zooms : [2,3,4,5,6],
        fillColor : "#0080FF",//"#8B0004",
        fillOpacity : 0.3, 
        /*strokeWidth : [2,3,4,8,16],
        strokeDashArray: [[6,4],[8,6],[12,8],[24,16],[48,32]],
        strokeCap: "butt"*/
    },
    "ressource": {
        zooms : [2,3,4,5,6],
        pointRadius : [3,6,10,14,24],
        fillColor : "#00FF00", 
        fillOpacity : 1,
        imgSrc: 'img/pictos/bois.ai',
        scale: [0.5,1,2,4,8]
    }
}

