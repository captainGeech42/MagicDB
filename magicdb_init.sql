CREATE DATABASE `magic`;

CREATE TABLE `magic`.`cards` (
	`id`        INT(11)                                            NOT NULL AUTO_INCREMENT,
	`timestamp` TIMESTAMP                                          NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`name`      VARCHAR(50)                                        NOT NULL,
	`mana`      VARCHAR(15)                                        NOT NULL,
	`rarity`    ENUM ('common', 'uncommon', 'rare', 'mythic_rare') NOT NULL,
	`in_deck`   ENUM ('yes', 'no')                                 NOT NULL,
	`image`     VARCHAR(100)                                       NOT NULL
	COMMENT 'relative path from webroot to card front image',
	`text`      VARCHAR(500)                                       NOT NULL
	COMMENT 'card text',
	PRIMARY KEY (`id`)
)
	ENGINE = INNODB;

CREATE TABLE `magic`.`decks` (
	`id`        INT(11)                                  NOT NULL AUTO_INCREMENT,
	`timestamp` TIMESTAMP                                NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`format`    ENUM ('standard', 'modern', 'commander') NOT NULL,
	`name`      VARCHAR(50)                              NOT NULL,
	`cards`     VARCHAR(600)                             NOT NULL
	COMMENT 'csv of card ids',
	PRIMARY KEY (`id`)
)
	ENGINE = INNODB;