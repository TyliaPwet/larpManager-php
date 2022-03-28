/* Requêtes pour la prise en charge de la cartographie dans larpmanager */
/* Correction d'une géométrir mal formatée */ 
UPDATE territoire SET geojson='{"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[85,-121.6875],[88.4375,-123.4375],[89.0625,-122.625],[90.25,-123.3125],[91.875,-123.375],[93.3125,-125.4375],[94.875,-126.25],[94.3125,-127.125],[92.625,-127.4375],[91.875,-128.1875],[91.0625,-127.875],[90.5,-128.1875],[89.125,-127.3125],[88.0625,-127.8125],[85.75,-127.1875],[84.6875,-127.1875],[83.9375,-127.3125],[82.9375,-125.125],[84.300,-124.125],[85,-121.6875]]]}}' WHERE id=384;

/* ajout et init d'une géométrie pour l'ancrage du label */
ALTER TABLE territoire ADD COLUMN geojson_label VARCHAR(100) AFTER geojson;
UPDATE territoire SET geojson_label = ST_AsGeoJson(ST_CENTROID(ST_GeomFromGeoJson(geojson))) WHERE geojson IS NOT NULL;

/* ajout et init d'un champ pour le texte du label, avec séparateur # pour un saut de ligne */
ALTER TABLE territoire ADD COLUMN texte_label VARCHAR(45) AFTER geojson_label;
UPDATE territoire SET texte_label = TRIM(REPLACE(nom, ',', '#'));
