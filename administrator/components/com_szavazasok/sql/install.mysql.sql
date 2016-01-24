CREATE TABLE IF NOT EXISTS `#__szavazasok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temakor_id` int(11) NOT NULL,
  `megnevezes` varchar(120) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Szavazás megnevezése',
  `leiras` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Szavazás leírása',
  `titkos` int(11) NOT NULL COMMENT '0-nyilt, 1-titkos, 2-szigoruan titkos',
  `szavazok` int(11) NOT NULL COMMENT '0-e-mailben, 1-regisztráltak, 2-téma tagok',
  `alternativajavaslok` int(11) NOT NULL COMMENT '10-szavazok, 11-indito és adminok',
  `vita1_vege` date NOT NULL COMMENT 'alternativa javaslati vita határidő',
  `vita2_vege` date NOT NULL COMMENT 'részletes vita hattáridő',
  `szavazas_vege` date NOT NULL COMMENT 'szavazás vég határidő',
  `vita1` int(11) NOT NULL COMMENT '0-nem ebben az állapotban van, 1-ebben az állapotban van',
  `vita2` int(11) NOT NULL COMMENT '0-nem ebben az állapotban van, 1-ebben az állapotban van',
  `szavazas` int(11) NOT NULL COMMENT '0-nem ebben az állapotban van, 1-ebben az állapotban van',
  `lezart` int(11) NOT NULL COMMENT '0-nem, 1-igen',
  `letrehozo` int(11) NOT NULL COMMENT 'user-id',
  `letrehozva` date NOT NULL COMMENT 'létrehozás időpontja',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

