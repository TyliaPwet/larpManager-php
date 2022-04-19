var Util = {
	rgbaToHex: function (rgba) {
		function hex(number) {
			if (number > 255) {
				throw '\'' + number + '\'\' is greater than 255(0xff);';
			}
			var str = Number(number).toString(16);
			return ('0' + str).slice(-2);
		}
		var regex = /rgba?\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*(?:,\s*(0?.?\d+)\s*)?\)/;
		var parsed = regex.exec(rgba);
		if (!parsed) {
			throw 'Invalid format: ' + rgba;
		}
		var red = parsed[1];
		var green = parsed[2];
		var blue = parsed[3];
		var alpha = parsed[4];
		var elems = [
			hex(red),
			hex(green),
			hex(blue)
		];
		var result = {};
		result.hex = '#' + elems.join('');
		if (alpha) {
			result.opacity = parseFloat(alpha);
		}
		return result;
	},
		
	/**
	 * Function hexToRgba()
	 * ---------------------
	 **/
	hexToRgba: function (hex, opacity) {
		var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		hex = hex.replace(shorthandRegex, function (m, r, g, b) {
			return r + r + g + g + b + b;
		});
		var rgb = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		rgb = rgb ? {
			r: parseInt(rgb[1], 16),
			g: parseInt(rgb[2], 16),
			b: parseInt(rgb[3], 16)
		} : null;
		var result = rgb ? 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + opacity + ')' : null;
		return result;
	},
    
    /**
	 * Functions transform, LonLatToLM() et LMtoLonLat()
	 * ---------------------
     * On ne devrait pas avoir à créer ces fonctions... OpenLayers permet de créer une projection custom et les fonctions des transformation de coordonnées de/vers LonLat
     * Mais je n'arrive pas à le faire fonctionner... Ca marcherait avec une définition proj4 mais je ne sais pas le faire
     * TRANSFORME directement les coordonnées passées en paramètre
	 **/
    LonLatToLM: function (coords) {
        coords[0]= coords[0]*64;
        coords[1]= 11264 + coords[1]*64;
    },
    LMToLonLat: function (coords) {
        coords[0]= Math.round(coords[0])/64;
        coords[1]= (Math.round(coords[1])-11264)/64;
    },
    transform: function (geom, origin, dest) {
        var self = this;
        var coords = geom.getCoordinates();
        var laFonction;
        
        if (origin == 'EPSG:4326') { laFonction = self.LonLatToLM; } 
        else { 
            if (origin == 'LMPROJ') { laFonction = self.LMToLonLat;}
            else { console.log('projection inconnue');
                   return; }
        } // je ne teste pas la valeur de dest car on n'a pas l'usage pour l'instant mais je mets ce paramètre pour plus de lisibilité et au cas où évolution plus tard
        
        var coordsToLM = function(tab) {
            if (Array.isArray(tab[0])) {
                var XY = [];
                for (var p=0; p<tab.length; p++) {
                    XY.push(coordsToLM(tab[p]));
                }
                return XY;
            } else {
                return laFonction(tab);
            }
        };        
        coordsToLM(coords);
        geom.setCoordinates(coords);  
    },
    
    /**
	 * Fonctions toDegrees(), toRadians()
	 * ---------------------
	 */
	toDegrees : function(angleInRadians) {
		return angleInRadians * 180 / Math.PI;
	},
	toRadians : function(angleInDegrees) {
		return angleInDegrees * Math.PI / 180;
	}
};
