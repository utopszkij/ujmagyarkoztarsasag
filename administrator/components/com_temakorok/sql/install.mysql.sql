CREATE TABLE IF NOT EXISTS `#__temakorok` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'téma egyedi azonosító',
  `megnevezes` varchar(120) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'téma megnevezése',
  `leiras` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'téma leírása',
  `lathatosag` int(2) NOT NULL DEFAULT '0' COMMENT '0-mindenki, 1-regisztraltak, 2-téma tagok',
  `szavazok` int(2) NOT NULL DEFAULT '1' COMMENT '1-regisztraltak, 2-téma tagok',
  `szavazasinditok` int(2) NOT NULL DEFAULT '1' COMMENT '1-regisztraltak, 2 -téma tagok, 3-téma adminok',
  `allapot` int(2) NOT NULL DEFAULT '0' COMMENT '0-aktiv, 1 - lezárt',
  `letrehozo` int(11) NOT NULL COMMENT 'user_id',
  `letrehozva` datetime NOT NULL COMMENT 'létrehozás időpontja',
  `lezaro` int(11) NOT NULL COMMENT 'user_id',
  `lezarva` datetime NOT NULL COMMENT 'lezárás időpontja',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

