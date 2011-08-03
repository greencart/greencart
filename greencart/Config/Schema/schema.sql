
# administrators ---------------------------------------------------------------

CREATE TABLE `gc_administrators` (
	`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username`  VARCHAR(20) NOT NULL,
	`password`  VARCHAR(40) NOT NULL,
	`name`      VARCHAR(60) NOT NULL,
	`email`     VARCHAR(80) NOT NULL,
	`enabled`   BOOL NOT NULL DEFAULT TRUE,
	`online`    DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`lastlogin` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`created`   DATETIME NOT NULL,
	`updated`   DATETIME NOT NULL,
	PRIMARY KEY             (`id`),
	UNIQUE KEY  `username`  (`username`),
	KEY         `password`  (`password`),
	KEY         `name`      (`name`),
	UNIQUE KEY  `email`     (`email`),
	KEY         `enabled`   (`enabled`),
	KEY         `online`    (`online`),
	KEY         `lastlogin` (`lastlogin`),
	KEY         `created`   (`created`),
	KEY         `updated`   (`updated`)
) ENGINE=MyISAM, CHARSET=UTF8;

# configuration ----------------------------------------------------------------

CREATE TABLE `gc_configuration` (
	`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`key`       VARCHAR(255) NOT NULL,
	`value`     TEXT,
	`updated`   DATETIME NOT NULL,
	PRIMARY KEY       (`id`),
	UNIQUE KEY  `key` (`key`)
) ENGINE=MyISAM, CHARSET=UTF8;

# customers --------------------------------------------------------------------

CREATE TABLE `gc_customers` (
	`id`           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name`         VARCHAR(40) NOT NULL,
	`email`        VARCHAR(80) NOT NULL,
	`password`     VARCHAR(40) NOT NULL,

	`ip`           TEXT,
	`tmp`          TEXT,

	`enabled`      BOOL NOT NULL DEFAULT FALSE,
	`blocked`      BOOL NOT NULL DEFAULT FALSE,
	`online`       DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`lastlogin`    DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`created`      DATETIME NOT NULL,
	`updated`      DATETIME NOT NULL,
	PRIMARY KEY                   (`id`),
	KEY            `name`         (`name`),
	UNIQUE KEY     `email`        (`email`),
	KEY            `password`     (`password`),
	KEY            `enabled`      (`enabled`),
	KEY            `blocked`      (`blocked`),
	KEY            `online`       (`online`),
	KEY            `lastlogin`    (`lastlogin`),
	KEY            `created`      (`created`),
	KEY            `updated`      (`updated`)
) ENGINE=MyISAM, CHARSET=UTF8;

# sessions ---------------------------------------------------------------------

CREATE TABLE `gc_sessions` (
	`id`        CHAR(32) NOT NULL,
	`data`      TEXT,
	`expires`   INT(10)  UNSIGNED,
	PRIMARY KEY           (`id`),
	KEY         `expires` (`expires`)
) ENGINE=MyISAM, CHARSET=UTF8;
