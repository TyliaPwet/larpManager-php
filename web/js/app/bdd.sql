/* Requêtes pour la prise en charge de la cartographie dans larpmanager */
/* Correction d'une géométrie mal formatée */ 
UPDATE territoire SET geojson='{"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[85,-121.6875],[88.4375,-123.4375],[89.0625,-122.625],[90.25,-123.3125],[91.875,-123.375],[93.3125,-125.4375],[94.875,-126.25],[94.3125,-127.125],[92.625,-127.4375],[91.875,-128.1875],[91.0625,-127.875],[90.5,-128.1875],[89.125,-127.3125],[88.0625,-127.8125],[85.75,-127.1875],[84.6875,-127.1875],[83.9375,-127.3125],[82.9375,-125.125],[84.300,-124.125],[85,-121.6875]]]}}' WHERE id=384;

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
INSERT INTO geo_surf (categ, geojson, territoire_id) SELECT 'pays', geojson, id FROM territoire WHERE territoire_id IS NULL AND geojson IS NOT NULL;
INSERT INTO geo_surf (categ, geojson, territoire_id) SELECT 'fief', t.geojson, t.id FROM territoire t LEFT OUTER JOIN territoire z ON t.id = z.territoire_id WHERE t.geojson IS NOT NULL GROUP BY t.id, t.nom HAVING COUNT(z.id)=0;
INSERT INTO geo_label (categ, geojson, texte, territoire_id) SELECT 'label_pays', ST_AsGeoJSON(ST_CENTROID(ST_GeomFromGeoJSON(geojson))) ,REPLACE(nom, ',', '#'), id FROM territoire WHERE territoire_id IS NULL AND geojson IS NOT NULL;
INSERT INTO geo_label (categ, geojson, texte, territoire_id) SELECT 'label_fief', ST_AsGeoJSON(ST_CENTROID(ST_GeomFromGeoJSON(t.geojson))) ,REPLACE(t.nom, ',', '#'), t.id FROM territoire t LEFT OUTER JOIN territoire z ON t.id = z.territoire_id WHERE t.geojson IS NOT NULL GROUP BY t.id, t.nom HAVING COUNT(z.id)=0; 


/* Exemples de villes en Vanaheim */
INSERT INTO geo_picto (categ, geojson) VALUES ('ville', '{"type":"Point","coordinates":[48.390625,-15.8125]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('ville', '{"type":"Point","coordinates":[49.765625,-2.8125]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('ville', '{"type":"Point","coordinates":[59.953125,-10.3125]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('ville', '{"type":"Point","coordinates":[35.015625,-9]}');

/* Pictos 'E' */
INSERT INTO geo_picto (categ, geojson) VALUES ('exploration', '{"type":"Point","coordinates":[65.1875,-0.984375]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('exploration', '{"type":"Point","coordinates":[146.9375,-10.234375]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('exploration', '{"type":"Point","coordinates":[176.0625,-25.984375]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('exploration', '{"type":"Point","coordinates":[236.5625,-63.484375]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('exploration', '{"type":"Point","coordinates":[174.859375,-107.859375]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('exploration', '{"type":"Point","coordinates":[159.53125,-135.796875]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('exploration', '{"type":"Point","coordinates":[132.78125,-134.296875]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('exploration', '{"type":"Point","coordinates":[226.15625,-161.046875]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('exploration', '{"type":"Point","coordinates":[63.90625,-155.546875]}');
INSERT INTO geo_picto (categ, geojson) VALUES ('exploration', '{"type":"Point","coordinates":[50.40625,-128.046875]}');

/* Route commerciale */
INSERT INTO geo_ligne (categ, geojson) VALUES ('caravane', '{"type":"LineString","coordinates":[[38.03125,-100.015625],[41.65625,-96.171875],[43.0625,-96.015625],[43.34375,-94.640625],[44.625,-94.703125],[45.96875,-93.703125],[46.96875,-92.859375],[46.46875,-91.296875],[47.75,-90.984375],[49.125,-90.609375],[49.6875,-89.328125],[49.90625,-87.984375],[49.65625,-86.984375],[50.15625,-86.265625],[51.375,-84.859375],[51.46875,-84.046875],[51.75,-83.109375],[52.4375,-82.609375],[53.375,-82.359375],[53.90625,-81.921875],[54.71875,-80.921875],[55,-79.578125],[55.46875,-78.546875],[56.34375,-77.984375],[56.921875,-75.78125],[57.046875,-74.28125],[56.890625,-72.84375],[55.265625,-70],[55.078125,-69.3125],[54.578125,-67.65625],[54.890625,-66.5],[55.65625,-65.875],[57.53125,-65.25],[72.71875,-64.4375],[74.21875,-65.125],[83.28125,-64.1875],[84.65625,-65.25],[86.46875,-64.5],[88.21875,-64.59375],[89.78125,-65.40625],[93.03125,-67.59375],[93.65625,-69.96875],[94.96875,-71.03125],[97.96875,-71.84375],[99.875,-74.9375],[97,-76],[97.8125,-79.75],[98.8125,-81.3125],[98.125,-82.8125],[97.5,-82.625],[95.59375,-81.28125],[94.3125,-81],[92.75,-81.28125],[91,-82.1875],[86.1875,-84.75],[83.25,-86.5625],[82.5625,-87.8125],[82.875,-89.5],[84.4375,-90.625],[87.3125,-91.3125],[90.9375,-91.5625],[93.25,-91.3125],[96.625,-90.3125],[99.1875,-91.125],[102.6875,-91.4375],[107.5625,-91],[111.3125,-90.375],[112.9375,-90.4375],[127.5625,-90.6875],[133.25,-90.25],[132.75,-92.6875],[133,-93.6875],[132.5,-95.8125],[133,-96.6875],[133.125,-98.1875],[133.1875,-100.125],[133.125,-101.9375],[133.6875,-102.375],[135.0625,-102.0625],[136.5625,-102.0625],[137.75,-102.625],[139.0625,-103.75],[140.5,-104.0625],[141.875,-104.25],[143.1875,-105.625],[144.9375,-106.375],[145.75,-107.3125],[146,-108.1875],[146.3125,-108.75],[147.1875,-108.5],[148.25,-108.5],[149.4375,-108.625],[151.375,-109],[153.6875,-109.4375],[154.6875,-110.0625],[154.8125,-111.125],[154.4375,-111.8125],[154.625,-113.125],[155.25,-113.875],[156.6875,-113.875],[157.1875,-114.6875],[155.8125,-115.375],[155.75,-116.1875],[156.625,-116.75],[158.8125,-117.4375],[161.375,-117.5],[162.1875,-116.5625],[162.4375,-115.4375],[163.8125,-114.4375],[165.875,-113.125],[168.4375,-111.5625],[170.6875,-110.5],[172.0625,-108.4375],[172.625,-109.125],[173.0625,-110.8125],[174,-111.375],[175.1875,-111.8125],[175.125,-112.6875],[175.125,-113.875],[174.625,-115.0625],[174,-116.25],[174.1875,-116.875],[175.5625,-116.25],[176.75,-116.5625],[177.75,-116.25],[178.5,-114.125],[178.8125,-112.25],[179.3125,-110.0625],[181.125,-109.875],[183.0625,-109.9375],[185.4375,-109.75],[187.75,-108.8125],[190.09375,-109],[190.96875,-107.9375],[192.09375,-108],[192.53125,-105.875],[192.453125,-104.28125],[193.59375,-103.1875],[195.96875,-100.8125],[197.84375,-100.1875],[197.84375,-91.125],[199.53125,-89.375],[200.09375,-82.6875],[202.21875,-82.25],[206.40625,-77.6875],[207.59375,-78],[208.84375,-79.875],[209.96875,-80.375],[213.09375,-81.875],[214.46875,-83.5625],[216.28125,-84],[215.59375,-81.9375],[213.46875,-79.5],[212.40625,-77.9375],[212.765625,-77.03125],[216.34375,-75],[216.390625,-73.65625],[215.328125,-72.21875],[215.828125,-69.46875],[217.203125,-66.84375],[218.640625,-66.03125],[220.203125,-65.65625]]}');


