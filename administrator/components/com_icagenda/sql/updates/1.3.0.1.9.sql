UPDATE `#__icagenda` SET version='1.3 beta4', releasedate='2012-12-28' WHERE id=1;

ALTER TABLE `#__icagenda_registration` MODIFY COLUMN `date` TEXT(65535)  NOT NULL;
