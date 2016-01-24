UPDATE `#__icagenda` SET version='2.1.14', releasedate='2013-05-29' WHERE id=1;
UPDATE `#__icagenda_events` SET language='*' WHERE language='';

ALTER TABLE `#__icagenda_registration` ADD COLUMN `itemid` INT(11) NOT NULL AFTER `userid`;
