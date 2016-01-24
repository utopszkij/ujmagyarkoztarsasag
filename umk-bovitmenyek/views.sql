DELIMITER $$

USE `ujmagyarkoztarsasag`$$

DROP VIEW IF EXISTS `umk_szavazasok_igennem`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `umk_szavazasok_igennem` AS (
SELECT
  `umk_szavazasok_in`.`szavazas_id` AS `szavazas_id`,
  SUM(`umk_szavazasok_in`.`igen`)   AS `igen`,
  SUM(`umk_szavazasok_in`.`nem`)    AS `nem`
FROM `umk_szavazasok_in`
GROUP BY `umk_szavazasok_in`.`szavazas_id`)$$

DELIMITER ;