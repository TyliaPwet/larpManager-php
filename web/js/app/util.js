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
	}
};