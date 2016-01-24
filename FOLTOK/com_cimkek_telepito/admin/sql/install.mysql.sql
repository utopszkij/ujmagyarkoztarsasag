CREATE TABLE IF NOT EXISTS `#__cimkek` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cimke` varchar(32) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;
CREATE TABLE IF NOT EXISTS `#__cimke_szavazasok` (
  `cimke` varchar(32) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `szavazas_id` int(11)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;
ALTER TABLE #__szavazasok ADD `cimkek` varchar(128) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL;

/* cimkek tábla init */
insert  into `#__cimkek`(`id`,`cimke`) values 
(1,'Európai Unió'),(2,'Kultúra'),(3,'Egészségügy'),
(4,'Nyugdíj rendszer'),(5,'Oktatás'),(6,'Munkaügy'),
(7,'Honvédelem'),(8,'Demokrácia'),(9,'Egyéb külügyek'),
(10,'Rendészet'),(11,'Közigazgatás'),(12,'Igazságügy'),
(13,'Szociális ellátás'),(14,'Pénzügy'),(15,'Adózás'),
(16,'Mezőgazdaság'),(17,'Vidékfejlesztés'),(18,'Ipar'),
(19,'Kereskedelem'),(20,'Közlekedés'),(21,'Szállítás'),
(22,'Egyéb gazdaság'),(23,'Vízügy'),(24,'Energetika'),
(25,'Ökológia'),(26,'Informatika'),(27,'Országgyűlés'),
(28,'Önkormányzatok'),(29,'Népszavazások'),(30,'FNA'),
(31,'li-de'),(32,'Nyilvánosság'),(33,'Emberi jogok');


/* cimke_szavazasok tábla init */
INSERT INTO #__cimke_szavazasok
SELECT c.cimke, sz.id
FROM ekh_cimkek c, ekh_szavazasok sz
WHERE sz.megnevezes LIKE CONCAT("%",c.cimke,"%") OR
      sz.leiras LIKE CONCAT("%",c.cimke,"%") 
ORDER BY c.cimke;


/* szavazaok.cimkek beállítása */
UPDATE #__szavazasok sz,
       (SELECT szavazas_id, GROUP_CONCAT(cimke) cimkek
        FROM ekh_cimke_szavazasok
        GROUP BY szavazas_id ) c
SET sz.cimkek = c.cimkek        
WHERE sz.id = c.szavazas_id;

