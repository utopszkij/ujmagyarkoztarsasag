UPDATE `#__icagenda` SET version='2.1.7', releasedate='2013-04-29' WHERE id=1;

ALTER TABLE `#__icagenda_events` ADD COLUMN `language` CHAR(7) NOT NULL AFTER `access`;

ALTER TABLE `#__icagenda_events` ADD COLUMN `lng` FLOAT( 20, 16 ) NOT NULL AFTER `coordinate`;
ALTER TABLE `#__icagenda_events` ADD COLUMN `lat` FLOAT( 20, 16 ) NOT NULL AFTER `coordinate`;
