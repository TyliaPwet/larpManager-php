
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
