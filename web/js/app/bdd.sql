/* Requêtes pour la prise en charge de la cartographie dans larpmanager */
/* Correction d'une géométrir mal formatée */ 
UPDATE territoire SET geojson='{"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[85,-121.6875],[88.4375,-123.4375],[89.0625,-122.625],[90.25,-123.3125],[91.875,-123.375],[93.3125,-125.4375],[94.875,-126.25],[94.3125,-127.125],[92.625,-127.4375],[91.875,-128.1875],[91.0625,-127.875],[90.5,-128.1875],[89.125,-127.3125],[88.0625,-127.8125],[85.75,-127.1875],[84.6875,-127.1875],[83.9375,-127.3125],[82.9375,-125.125],[84.300,-124.125],[85,-121.6875]]]}}' WHERE id=384;

/* ajout et init d'une géométrie pour l'ancrage du label */
ALTER TABLE territoire ADD COLUMN geojson_label VARCHAR(100) AFTER geojson;
UPDATE territoire SET geojson_label = ST_AsGeoJson(ST_CENTROID(ST_GeomFromGeoJson(geojson))) WHERE geojson IS NOT NULL;

/* ajout et init d'un champ pour le texte du label, avec séparateur # pour un saut de ligne */
ALTER TABLE territoire ADD COLUMN texte_label VARCHAR(45) AFTER geojson_label;
UPDATE territoire SET texte_label = REPLACE(nom, ',', '#');

/* création des tables de stockage des autres géométries de fond */
CREATE TABLE geo_ligne (id INT UNSIGNED AUTO_INCREMENT NOT NULL, `type` VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;
CREATE TABLE geo_zone (id INT UNSIGNED AUTO_INCREMENT NOT NULL, `type` VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;
CREATE TABLE geo_picto (id INT UNSIGNED AUTO_INCREMENT NOT NULL, `type` VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, url VARCHAR(255), rotation INT DEFAULT 0, discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;
CREATE TABLE geo_label (id INT UNSIGNED AUTO_INCREMENT NOT NULL, `type` VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, texte VARCHAR(45) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'à définir!!', rotation INT DEFAULT 0, discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;

/* Exemples de villes en Vanaheim */
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('ville', '{"type":"Point","coordinates":[48.390625,-15.8125]}', 'cercle', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('ville', '{"type":"Point","coordinates":[49.765625,-2.8125]}', 'cercle', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('ville', '{"type":"Point","coordinates":[59.953125,-10.3125]}', 'cercle', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('ville', '{"type":"Point","coordinates":[35.015625,-9]}', 'cercle', 0);

/* Exemples de pictos 'E' */
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[65.1875,-0.984375]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[146.9375,-10.234375]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[176.0625,-25.984375]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[236.5625,-63.484375]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[174.859375,-107.859375]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[159.53125,-135.796875]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[132.78125,-134.296875]}', 'img/pictos/exploration.svg', 0);
/* non passées en base dev : */
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[226.15625,-161.046875]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[63.90625,-155.546875]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (`type`, geojson, url, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[50.40625,-128.046875]}', 'img/pictos/exploration.svg', 0);

/* création de la table qui stocke les styles */
CREATE TABLE geo_style (id INT UNSIGNED AUTO_INCREMENT NOT NULL, `nom` VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, zoom INT NOT NULL, stylejson LONGTEXT NOT NULL, discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;

/* Préfixe du nom de style :
A_ pour un objet surfacique (Polygon)
L_ pour un linéaire (Line)
P_ pour un ponctuel/picto (Point)
T_ pour un label (Point) */

/* propriétés possibles pour chaque type de style :
A_ : strokeColor, strokeOpacity, strokeWidth, strokeDashArray, fillColor, fillOpacity
L_ : strokeColot, strokeOpacity, strokeWidth, strokeDashArray (strokeEnd = peut-être à ajouter pour les flèches de soutien entre domaines, à voir plus tard)
P_ : imgType (icon | shape), src (url | shapeName), angle, imgColor, imgOpacity, imgRadius
T_ : fontFamily, fontWeight, fontSize, strokeColor, strokeOpacity, strokeWidth, fillColor, fillOpacity, angle

/* Init de styles pour la carte de base */
/* je ne vois pas l'intérêt de mettre un style pour les zooms 0 et 1 qui sont trop petits pour être exploités, à mon avis...*/
/* frontières pays */
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('A_contours1',2,'{strokeColor: "#8B0004", strokeOpacity: 1, strokeWidth: 2');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('A_contours1',3,'{strokeColor: "#8B0004", strokeOpacity: 1, strokeWidth: 3');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('A_contours1',4,'{strokeColor: "#8B0004", strokeOpacity: 1, strokeWidth: 4');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('A_contours1',5,'{strokeColor: "#8B0004", strokeOpacity: 1, strokeWidth: 4');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('A_contours1',6,'{strokeColor: "#8B0004", strokeOpacity: 1, strokeWidth: 4');

/* frontières fiefs */
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('A_contours2',4,'{strokeColor: "#B98B54", strokeOpacity: 1, strokeWidth: 1');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('A_contours2',5,'{strokeColor: "#B98B54", strokeOpacity: 1, strokeWidth: 1');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('A_contours2',6,'{strokeColor: "#B98B54", strokeOpacity: 1, strokeWidth: 1');

/* villes rond rouge */
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('P_rond1',4,'{imgType: "shape", src: "cercle", imgColor: "#8B0004", imgOpacity: 1, imgRadius:5');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('P_rond1',5,'{imgType: "shape", src: "cercle", imgColor: "#8B0004", imgOpacity: 1, imgRadius:10');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('P_rond1',6,'{imgType: "shape", src: "cercle", imgColor: "#8B0004", imgOpacity: 1, imgRadius:20');

/* labels pays */
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('T_titre1',2,'{fontFamily: "Trebuchet", fontWeight: "normal", fontSize: "12", strokeColor: "#FFFFFF", strokeOpacity: 1, strokeWidth: 1, fillColor: "#FFFFFF", fillOpacity:1, interligne: 300, transformation: "toUpper"}');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('T_titre1',3,'{fontFamily: "Trebuchet", fontWeight: "normal", fontSize: "24", strokeColor: "#FFFFFF", strokeOpacity: 1, strokeWidth: 1, fillColor: "#FFFFFF", fillOpacity:1, interligne: 300, transformation: "toUpper"}');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('T_titre1',4,'{fontFamily: "Trebuchet", fontWeight: "normal", fontSize: "48", strokeColor: "#FFFFFF", strokeOpacity: 1, strokeWidth: 1, fillColor: "#FFFFFF", fillOpacity:1, interligne: 300, transformation: "toUpper"}');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('T_titre1',5,'{fontFamily: "Trebuchet", fontWeight: "normal", fontSize: "96", strokeColor: "#FFFFFF", strokeOpacity: 1, strokeWidth: 1, fillColor: "#FFFFFF", fillOpacity:1, interligne: 300, transformation: "toUpper"}');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('T_titre1',6,'{fontFamily: "Trebuchet", fontWeight: "normal", fontSize: "192", strokeColor: "#FFFFFF", strokeOpacity: 1, strokeWidth: 1, fillColor: "#FFFFFF", fillOpacity:1, interligne: 300, transformation: "toUpper"}');

/* labels fiefs */
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('T_texte1',4,'{fontFamily: "Fiefs", fontWeight: "normal", fontSize: "16", strokeColor: "#000000", strokeOpacity: 1, strokeWidth: 1, fillColor: "#FFFFFF", fillOpacity:1, interligne: 84, transformation: "none"}');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('T_texte1',5,'{fontFamily: "Fiefs", fontWeight: "normal", fontSize: "32", strokeColor: "#000000", strokeOpacity: 1, strokeWidth: 1, fillColor: "#FFFFFF", fillOpacity:1, interligne: 84, transformation: "none"}');
INSERT INTO geo_style (nom, zoom, stylejson) VALUES ('T_texte1',6,'{fontFamily: "Fiefs", fontWeight: "normal", fontSize: "64", strokeColor: "#000000", strokeOpacity: 1, strokeWidth: 1, fillColor: "#FFFFFF", fillOpacity:1, interligne: 84, transformation: "none"}');
