UPDATE `#__icagenda` SET version='3.2.0', releasedate='2013-09-20' WHERE id=2;

ALTER TABLE `#__icagenda_events` ADD COLUMN `daystime` VARCHAR(255) NOT NULL DEFAULT '' AFTER `weekdays`;
