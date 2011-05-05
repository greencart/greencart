
CREATE TABLE `gc_sessions` (
	`id`        CHAR(32) NOT NULL,
	`data`      TEXT,
	`expires`   INT(10) UNSIGNED,
	PRIMARY KEY           (`id`),
	KEY         `expires` (`expires`)
) ENGINE=MyISAM, DEFAULT CHARACTER SET UTF8;
