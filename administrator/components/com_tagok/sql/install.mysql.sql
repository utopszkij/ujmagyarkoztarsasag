CREATE TABLE IF NOT EXISTS `#__tagok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temakor_id` int(11) NOT NULL COMMENT 'témakör azonosító',
  `user_id` int(11) NOT NULL COMMENT 'Ha nyilt szavazás a szavazó user_id -je',
  `admin` int(11) DEFAULT NULL COMMENT '0-nem, 1-igen',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

