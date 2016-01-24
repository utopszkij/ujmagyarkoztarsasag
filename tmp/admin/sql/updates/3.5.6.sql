UPDATE `#__icagenda` SET version='3.5.6', releasedate='2015-06-29' WHERE id=3;

ALTER TABLE `#__icagenda_registration` DROP COLUMN `custom_fields`;
ALTER TABLE `#__icagenda_registration` ADD COLUMN `params` text NOT NULL AFTER `notes`;
