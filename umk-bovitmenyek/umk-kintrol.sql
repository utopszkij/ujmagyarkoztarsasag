-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;

INSERT INTO `umk_users` (`id`, `name`, `username`, `email`, `password`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`, `lastResetTime`, `resetCount`, `otpKey`, `otep`, `requireReset`) VALUES
(836,	'Super User',	'claymanus',	'gypeng@drezina.hu',	'$2y$10$OtPHhQq0R68zsdbM6vu.r.vI368jIs2xkhV1ZMAei9zZ8ZqNTxMMy',	0,	1,	'2016-01-21 20:13:45',	'2016-01-21 20:19:05',	'0',	'',	'0000-00-00 00:00:00',	0,	'',	'',	0);


INSERT INTO `umk_user_usergroup_map` (`user_id`, `group_id`) VALUES
(836,	8);

-- 2016-01-22 17:36:22
