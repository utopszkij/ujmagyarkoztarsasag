CREATE TABLE IF NOT EXISTS `#__kepviselok` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `kepviselo_id` int(11) DEFAULT NULL,
  `temakor_id` int(11) DEFAULT NULL,
  `szavazas_id` int(11) DEFAULT NULL,
  `lejarat` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

