/* Correction d'une géométrie mal formatée */ 
/*UPDATE territoire SET geojson='{"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[85,-121.6875],[88.4375,-123.4375],[89.0625,-122.625],[90.25,-123.3125],[91.875,-123.375],[93.3125,-125.4375],[94.875,-126.25],[94.3125,-127.125],[92.625,-127.4375],[91.875,-128.1875],[91.0625,-127.875],[90.5,-128.1875],[89.125,-127.3125],[88.0625,-127.8125],[85.75,-127.1875],[84.6875,-127.1875],[83.9375,-127.3125],[82.9375,-125.125],[84.300,-124.125],[85,-121.6875]]]}}' WHERE id=384;
*/
/* création des tables de stockage des autres géométries de fond */
CREATE TABLE geo_ligne (id INT UNSIGNED AUTO_INCREMENT NOT NULL, categ VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, territoire_id INT(11), discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;
CREATE TABLE geo_picto (id INT UNSIGNED AUTO_INCREMENT NOT NULL, categ VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, territoire_id INT(11), discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;
CREATE TABLE geo_label (id INT UNSIGNED AUTO_INCREMENT NOT NULL, categ VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, texte VARCHAR(45) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'à définir!!', rotation INT DEFAULT 0, territoire_id INT(11), discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;
CREATE TABLE geo_surf (id INT UNSIGNED AUTO_INCREMENT NOT NULL, categ VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, geojson LONGTEXT, territoire_id INT(11), discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', PRIMARY KEY(id)) ENGINE =InnoDB;

ALTER TABLE geo_ligne ADD CONSTRAINT `FK_6ECC33456901` FOREIGN KEY (territoire_id) REFERENCES territoire (`id`);
ALTER TABLE geo_picto ADD CONSTRAINT `FK_6ECC33456902` FOREIGN KEY (territoire_id) REFERENCES territoire (`id`);
ALTER TABLE geo_label ADD CONSTRAINT `FK_6ECC33456903` FOREIGN KEY (territoire_id) REFERENCES territoire (`id`);
ALTER TABLE geo_surf ADD CONSTRAINT `FK_6ECC33456904` FOREIGN KEY (territoire_id) REFERENCES territoire (`id`);

/* init des tables geo_surf et geo_label avec les infos correspondant aux territoires pays et fiefs */
/*INSERT INTO geo_surf (categ, geojson, territoire_id) SELECT 'pays', geojson, id FROM territoire WHERE territoire_id IS NULL AND geojson IS NOT NULL;
INSERT INTO geo_surf (categ, geojson, territoire_id) SELECT 'fief', t.geojson, t.id FROM territoire t LEFT OUTER JOIN territoire z ON t.id = z.territoire_id WHERE t.geojson IS NOT NULL GROUP BY t.id, t.nom HAVING COUNT(z.id)=0;
INSERT INTO geo_label (categ, geojson, texte, territoire_id) SELECT 'label_pays', ST_AsGeoJSON(ST_CENTROID(ST_GeomFromGeoJSON(geojson))) ,REPLACE(nom, ',', '#'), id FROM territoire WHERE territoire_id IS NULL AND geojson IS NOT NULL;
INSERT INTO geo_label (categ, geojson, texte, territoire_id) SELECT 'label_fief', ST_AsGeoJSON(ST_CENTROID(ST_GeomFromGeoJSON(t.geojson))) ,REPLACE(t.nom, ',', '#'), t.id FROM territoire t LEFT OUTER JOIN territoire z ON t.id = z.territoire_id WHERE t.geojson IS NOT NULL GROUP BY t.id, t.nom HAVING COUNT(z.id)=0; 
*/

/* création des tables de gestion de cartes */
CREATE TABLE geo_map (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
	code VARCHAR(20) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, 
	nom VARCHAR(50) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, 
	discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', 
	PRIMARY KEY(id)
) ENGINE =InnoDB;
INSERT INTO geo_map (code, nom) VALUES ('base','Carte de base'),('magna','Magna Carta');



CREATE TABLE geo_geomtype  (
	id TINYINT AUTO_INCREMENT NOT NULL, 
	code VARCHAR(30) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, 
	discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', 
	PRIMARY KEY(id)
) ENGINE =InnoDB;
INSERT INTO geo_geomtype (code) VALUES ('Label'),('LineString'),('Picto'),('Surface');



CREATE TABLE geo_categ (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL,  
	code VARCHAR(30) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, 
	geomtype_id TINYINT, 
	discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', 
	PRIMARY KEY(id)
) ENGINE =InnoDB;
ALTER TABLE geo_categ ADD CONSTRAINT `FK_6ECC33456905` FOREIGN KEY (geomtype_id) REFERENCES geo_geomtype (`id`);
INSERT INTO geo_categ (code, geomtype_id) VALUES ('label_pays',1),('label_fief',1),('label_poi',1),('label_passe',1),('label_riviere',1),('label_ville',1),('label_capitale',1),('label_magna',1),('label_sea',1);
INSERT INTO geo_categ (code, geomtype_id) VALUES ('lim_pays',2),('lim_fief',2),('lim_sea',2),('caravane',2),('riviere',2);
INSERT INTO geo_categ (code, geomtype_id) VALUES ('ville',3),('capitale',3),('exploration',3);



CREATE TABLE geo_style (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL,  
	code VARCHAR(30) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL, 
	stylejson LONGTEXT, 
	discr VARCHAR(255) CHARACTER SET utf8 COLLATE `utf8_unicode_ci` NOT NULL DEFAULT 'extended', 
	PRIMARY KEY(id)
) ENGINE =InnoDB;
INSERT INTO geo_style (code, stylejson) VALUES 
	('pays', '{"fontWeight":"normal", "fontSize":192, "fontFamily":"Pays", "interligne":250, "textTransformation":"toUpper", "strokeColor":"#FFFFFF", "strokeOpacity":1, "strokeWidth":1, "fillColor":"#FFFFFF", "fillOpacity":1}'),
	('paysfonce', '{"fontWeight":"normal", "fontSize":192, "fontFamily":"Pays", "interligne":250, "textTransformation":"toUpper", "strokeColor":"#705948", "strokeOpacity":1, "strokeWidth":1, "fillColor":"#705948", "fillOpacity":1}'),
	('mer', '{"fontWeight":"normal", "fontSize":112, "fontFamily":"Fiefs", "interligne":150, "textTransformation":"toUpper", "strokeColor":"#FFFFFF", "strokeOpacity":1, "strokeWidth":1, "fillColor":"#FFFFFF", "fillOpacity":1}'),
	('fief', '{"fontWeight":"normal", "fontSize":64, "fontFamily":"Fiefs", "interligne":60, "textTransformation":"none", "strokeColor":"#000000", "strokeOpacity":1, "strokeWidth":1, "fillColor":"#000000", "fillOpacity":1}'),
	('fiefmoyen', '"{"fontWeight":"normal", "fontSize":48, "fontFamily":"Fiefs", "interligne":40, "textTransformation":"none", "strokeColor":"#555555", "strokeOpacity":1, "strokeWidth":1, "fillColor":"#555555", "fillOpacity":1}'),
	('fiefmoyenrouge', '"{"fontWeight":"normal", "fontSize":48, "fontFamily":"Fiefs", "interligne":40, "textTransformation":"none", "strokeColor":"#8B0004", "strokeOpacity":1, "strokeWidth":1, "fillColor":"#8B0004", "fillOpacity":1}'),
	('fiefpetit', '{"fontWeight":"normal", "fontSize":32, "fontFamily":"Fiefs", "interligne":30, "textTransformation":"none", "strokeColor":"#000000", "strokeOpacity":1, "strokeWidth":1, "fillColor":"#000000", "fillOpacity":1}'),
	('fiefpetitbleu', '{"fontWeight":"normal", "fontSize":32, "fontFamily":"Fiefs", "interligne":30, "textTransformation":"none", "strokeColor":"#245579", "strokeOpacity":1, "strokeWidth":1, "fillColor":"#245579", "fillOpacity":1}'),
	('contourpays', '{"zooms":[2,3,4,5,6], "strokeColor":"#8B0004", "strokeOpacity":1, "strokeWidth":[2,2,2,3,3]}'),
	('contourfief', '{"zooms":[2,3,4,5,6], "strokeColor":"#8E6F58", "strokeOpacity":1, "strokeWidth":[1,1,1,1,1], "strokeDashArray":[[3,3],[3,3],[3,3],[3,3],[3,3]], "strokeCap":"butt"}'),
    ('caravane', '{"zooms":[2,3,4,5,6], "strokeColor":"#6600A1", "strokeOpacity":1, "strokeWidth":[2,4,8,16,32], "strokeDashArray":[[1,1,3,3],[1,1,3,3],[3,3,6,6], [6,6,12,12], [12,12,24,24]], "strokeCap":"butt"}'),
    ('riviere', '{zooms:[2,3,4,5,6], strokeColor:"#0080FF", strokeOpacity:0.5, strokeWidth:[4,8,16,32,64], strokeCap:"butt"}'),
    ('limitepays', '{zooms:[2,3,4,5,6], strokeColor:"#8B0004", strokeOpacity:1, strokeWidth:[2,3,4,8,16], strokeDashArray:[[6,4],[8,6],[12,8],[24,16],[48,32]], strokeCap:"butt"}'),
    ('limitefief', '{zooms:[2,3,4,5,6], strokeColor:"#8E6F58", strokeOpacity:1, strokeWidth:[1,2,2,4,4], strokeDashArray:[[1,1,3,3],[2,2,6,6],[2,2,6,6], [4,4,12,12], [4,4,12,12]], strokeCap:"butt"}'),
    ('limitemer', '{zooms:[2,3,4,5,6], strokeColor :"#FFFFFF", strokeOpacity:1, strokeWidth:[1,2,2,4,4], strokeDashArray:[[3,3],[6,6],[6,6],[12,12],[12,12]], strokeCap:"butt"}'),
    ('pictoville', '{pointRadius:24, fillColor:"#8B0004", fillOpacity:1, imgSrc:"cercle"}'),
    ('pictoexploration', '{fillOpacity:1, imgSrc:"img/pictos/exploration_gd.svg"}'),
    ('zonedeau', '{fillColor:"#0080FF", fillOpacity:0.3}');


CREATE TABLE geo_map_layers (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
	map_id INT UNSIGNED NOT NULL, 
	categ_id INT UNSIGNED NOT NULL, 
	style_id INT UNSIGNED NOT NULL, 
	zmin TINYINT NOT NULL DEFAULT 0, 
	zmax TINYINT NOT NULL DEFAULT 6, 
	ordre TINYINT NOT NULL DEFAULT 0, 
	PRIMARY KEY(id)
) ENGINE =InnoDB;
ALTER TABLE geo_map_layers ADD CONSTRAINT `FK_6ECC33456906` FOREIGN KEY (map_id) REFERENCES geo_map (`id`);
ALTER TABLE geo_map_layers ADD CONSTRAINT `FK_6ECC33456907` FOREIGN KEY (categ_id) REFERENCES geo_categ (`id`);
ALTER TABLE geo_map_layers ADD CONSTRAINT `FK_6ECC33456908` FOREIGN KEY (style_id) REFERENCES geo_style (`id`);


INSERT INTO geo_map_layers (map_id, categ_id, style_id, zmin, zmax, ordre) VALUES
	(1, 1, 2, 2, 3, 2),
	(1, 1, 1, 4, 6, 3),
	(1, 11, 14, 4, 6, 4),
	(1, 10, 13, 2, 6, 5),
	(1, 13, 11, 4, 6, 6),
	(1, 17, 17, 2, 6, 7),
	(1, 15, 16, 4, 6, 8),
	(1, 16, 16, 4, 6, 9),
	(1, 3, 5, 4, 6, 10),
	(1, 14, 8, 4, 6, 11),
	(1, 4, 6, 4, 6, 12),
	(1, 2, 4, 4, 6, 13),
	(1, 6, 5, 4, 6, 14),
	(1, 7, 6, 4, 6, 15);  


CREATE TABLE geo_obj (
	id INT UNSIGNED NOT NULL,
	categ_id INT UNSIGNED NOT NULL,
	geojson LONGTEXT,
	territoire_id INT(11) DEFAULT NULL,
	properties_json LONGTEXT
) ENGINE =InnoDB;
ALTER TABLE geo_obj ADD CONSTRAINT `FK_6ECC33456909` FOREIGN KEY (categ_id) REFERENCES geo_categ (`id`);
ALTER TABLE geo_obj ADD CONSTRAINT `FK_6ECC33456910` FOREIGN KEY (territoire_id) REFERENCES territoire (`id`);



CREATE TABLE geo_hidden_obj (
	map_layers_id INT UNSIGNED NOT NULL,
	obj_id INT UNSIGNED NOT NULL, 
	PRIMARY KEY(map_layers_id, obj_id)
) ENGINE =InnoDB;
/*
ALTER TABLE geo_hidden_obj ADD CONSTRAINT `FK_6ECC33456911` FOREIGN KEY (map_layers_id) REFERENCES geo_map_layers (`id`);
ALTER TABLE geo_hidden_obj ADD CONSTRAINT `FK_6ECC33456912` FOREIGN KEY (obj_id) REFERENCES geo_obj (`id`);*/



