CREATE TABLE IF NOT EXISTS `#__kepviselojeloltek` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `temakor_id` int(11) DEFAULT NULL,
  `szavazas_id` int(11) DEFAULT NULL,
  `leiras` text COLLATE utf8_hungarian_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

