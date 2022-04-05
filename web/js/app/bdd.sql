/* Requêtes pour la prise en charge de la cartographie dans larpmanager */
/* Correction d'une géométrie mal formatée */ 
UPDATE territoire SET geojson='{"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[85,-121.6875],[88.4375,-123.4375],[89.0625,-122.625],[90.25,-123.3125],[91.875,-123.375],[93.3125,-125.4375],[94.875,-126.25],[94.3125,-127.125],[92.625,-127.4375],[91.875,-128.1875],[91.0625,-127.875],[90.5,-128.1875],[89.125,-127.3125],[88.0625,-127.8125],[85.75,-127.1875],[84.6875,-127.1875],[83.9375,-127.3125],[82.9375,-125.125],[84.300,-124.125],[85,-121.6875]]]}}' WHERE id=384;

/* ajout et init d'une géométrie pour l'ancrage du label */
ALTER TABLE territoire ADD COLUMN geojson_label VARCHAR(100) AFTER geojson;
UPDATE territoire SET geojson_label = ST_AsGeoJson(ST_CENTROID(ST_GeomFromGeoJson(geojson))) WHERE geojson IS NOT NULL;

/* ajout et init d'un champ pour le texte du label, avec séparateur # pour un saut de ligne */
ALTER TABLE territoire ADD COLUMN texte_label VARCHAR(45) AFTER geojson_label;
UPDATE territoire SET texte_label = REPLACE(nom, ',', '#');

/* Ajout de géométries pour les labels des territoires Iles xxxx qui n'ont pas de géométrie, mais doivent apparaître sur la carte */
UPDATE territoire SET geojson_label = '{"type":"Point","coordinates":[127.546875,-139.03125]}' WHERE id = 435; /* Iles de perles */
UPDATE territoire SET geojson_label = '{"type":"Point","coordinates":[57.796875,-160.40625]}' WHERE id = 437; /* Iles du sud */
UPDATE territoire SET geojson_label = '{"type":"Point","coordinates":[155.296875,-139.53125]}' WHERE id = 438; /* Iles brumeuses */

/* création des tables de stockage des autres géométries de fond */
CREATE TABLE geo_ligne (id INT UNSIGNED AUTO_INCREMENT NOT NULL, categ VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;
CREATE TABLE geo_picto (id INT UNSIGNED AUTO_INCREMENT NOT NULL, categ VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, src VARCHAR(255), rotation INT DEFAULT 0, discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;

/* Exemples de villes en Vanaheim */
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('ville', '{"type":"Point","coordinates":[48.390625,-15.8125]}', 'cercle', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('ville', '{"type":"Point","coordinates":[49.765625,-2.8125]}', 'cercle', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('ville', '{"type":"Point","coordinates":[59.953125,-10.3125]}', 'cercle', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('ville', '{"type":"Point","coordinates":[35.015625,-9]}', 'cercle', 0);

/* Exemples de pictos 'E' */
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[65.1875,-0.984375]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[146.9375,-10.234375]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[176.0625,-25.984375]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[236.5625,-63.484375]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[174.859375,-107.859375]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[159.53125,-135.796875]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[132.78125,-134.296875]}', 'img/pictos/exploration.svg', 0);
/* non passées en base dev : */
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[226.15625,-161.046875]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[63.90625,-155.546875]}', 'img/pictos/exploration.svg', 0);
INSERT INTO geo_picto (categ, geojson, src, rotation) VALUES ('exploration', '{"type":"Point","coordinates":[50.40625,-128.046875]}', 'img/pictos/exploration.svg', 0);

/* Exemples de segments de route commerciale */
INSERT INTO geo_ligne (categ, geojson) VALUES ('caravane', '{"type":"LineString","coordinates":[[38.03125,-100.015625],[41.65625,-96.171875],[43.0625,-96.015625],[43.34375,-94.640625],[44.625,-94.703125],[45.96875,-93.703125],[46.6875,-91.328125],[47.75,-90.984375],[49.125,-90.609375],[49.6875,-89.328125],[49.90625,-87.984375],[49.65625,-86.984375],[50.15625,-86.265625],[51.375,-84.859375],[51.46875,-84.046875],[51.75,-83.109375],[52.4375,-82.609375],[53.375,-82.359375],[53.90625,-81.921875],[54.71875,-80.921875],[55,-79.578125],[55.46875,-78.546875],[56.34375,-77.984375],[56.875,-77.796875]]}');


/* A créer */
CREATE TABLE geo_surf (id INT UNSIGNED AUTO_INCREMENT NOT NULL, categ VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;
CREATE TABLE geo_label (id INT UNSIGNED AUTO_INCREMENT NOT NULL, categ VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, texte VARCHAR(45) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'à définir!!', rotation INT DEFAULT 0, discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;


