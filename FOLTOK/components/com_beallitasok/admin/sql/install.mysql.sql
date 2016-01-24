CREATE TABLE IF NOT EXISTS `#__beallitasok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temakor_felvivo` int(11) NOT NULL COMMENT '1-regisztráltak, 2-adminok',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

