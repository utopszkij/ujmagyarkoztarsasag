UPDATE `#__icagenda` SET version='2.1 beta', releasedate='2013-02-21' WHERE id=1;

ALTER TABLE `#__icagenda_events` ADD COLUMN `asset_id` INT(10) NOT NULL DEFAULT '0' AFTER `id`;


ALTER TABLE `#__icagenda_events` ADD COLUMN `modified_by` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `alias`;
ALTER TABLE `#__icagenda_events` ADD COLUMN `modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `alias`;
ALTER TABLE `#__icagenda_events` ADD COLUMN `created_by_alias` VARCHAR(255) NOT NULL AFTER `alias`;
ALTER TABLE `#__icagenda_events` ADD COLUMN `created_by` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `alias`;
ALTER TABLE `#__icagenda_events` ADD COLUMN `created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `alias`;
ALTER TABLE `#__icagenda_events` ADD COLUMN `access` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `alias`;
