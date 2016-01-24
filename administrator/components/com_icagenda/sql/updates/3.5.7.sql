UPDATE `#__icagenda` SET version='3.5.7', releasedate='2015-07-16' WHERE id=3;

ALTER TABLE `#__icagenda_registration` ADD COLUMN `asset_id` int(10) NOT NULL DEFAULT '0' AFTER `id`;
ALTER TABLE `#__icagenda_registration` ADD COLUMN `modified_by` int(10) unsigned NOT NULL DEFAULT '0' AFTER `params`;
ALTER TABLE `#__icagenda_registration` ADD COLUMN `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `params`;
ALTER TABLE `#__icagenda_registration` ADD COLUMN `created_by` int(10) unsigned NOT NULL DEFAULT '0' AFTER `params`;
ALTER TABLE `#__icagenda_registration` ADD COLUMN `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `params`;
