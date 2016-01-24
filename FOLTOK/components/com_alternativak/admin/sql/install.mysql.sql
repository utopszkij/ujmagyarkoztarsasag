CREATE TABLE IF NOT EXISTS `#__alternativak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temakor_id` int(11) NOT NULL,
  `szavazas_id` int(11) NOT NULL,
  `megnevezes` varchar(120) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Alternativa megnevezése',
  `leiras` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Alternatíva leírása',
  `letrehozo` int(11) NOT NULL COMMENT 'user-id',
  `letrehozva` date NOT NULL COMMENT 'létrehozás időpontja',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

