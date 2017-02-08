CREATE DATABASE IF NOT EXISTS `magic`;

CREATE TABLE IF NOT EXISTS `magic`.`cards` (
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

CREATE TABLE IF NOT EXISTS `magic`.`decks` (
	`id`        INT(11)                                  NOT NULL AUTO_INCREMENT,
	`timestamp` TIMESTAMP                                NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`format`    ENUM ('standard', 'modern', 'commander') NOT NULL,
	`name`      VARCHAR(50)                              NOT NULL,
	`cards`     VARCHAR(600)                             NOT NULL
	COMMENT 'csv of card ids',
	PRIMARY KEY (`id`)
)
	ENGINE = INNODB;

-- the next set of queries are for test data population, remove these lines and reinstantiate
-- the database once testing has concluded and real data is being added to the database

INSERT INTO `magic`.`cards` (name, mana, rarity, in_deck, image, text) VALUES (
	'ragnaros',
	'5g1o',
	'mythic_rare',
	'no',
	'none/',
	'best card from not innistrad'
);

INSERT INTO `magic`.`cards` (name, mana, rarity, in_deck, image, text) VALUES (
	'murloc',
	'1b1o',
	'common',
	'no',
	'none/',
	'most powerful card known to man'
);

INSERT INTO `magic`.`decks` (format, name, cards) VALUES (
	'standard',
	'intentionally illegal standard deck',
	'1'
);

INSERT INTO `magic`.`decks` (format, name, cards) VALUES (
	'commander',
	'intentionally illegal commander deck',
	'1,2'
);

