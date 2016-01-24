UPDATE `#__icagenda` SET version='3.4.0-beta1', releasedate='2014-07-23' WHERE id=3;

ALTER TABLE `#__icagenda_events` ADD COLUMN `shortdesc` TEXT NOT NULL DEFAULT '' AFTER `lng`;
