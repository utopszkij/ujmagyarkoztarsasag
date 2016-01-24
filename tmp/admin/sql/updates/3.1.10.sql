UPDATE `#__icagenda` SET version='3.1.10', releasedate='2013-09-12' WHERE id=2;

ALTER TABLE `#__icagenda_events` ADD COLUMN `approval` INT(11)  NOT NULL DEFAULT '0' AFTER `state`;
