CREATE DATABASE IF NOT EXISTS `magic`;

CREATE TABLE IF NOT EXISTS `magic`.`cards` (
	`id`        INT(11)                                            NOT NULL AUTO_INCREMENT,
	`timestamp` TIMESTAMP                                          NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`name`      VARCHAR(50)                                        NOT NULL,
	`mana`      VARCHAR(15)                                        NOT NULL,
	`typeline`	VARCHAR(50)                                        NOT NULL,
	`set`		VARCHAR(10)                                        NOT NULL
	COMMENT 'abbreviated set (i.e. innistrad->isd)',
	`set_number` INT(3)                                            NOT NULL
	COMMENT 'card number in the set',
	`rarity`    ENUM ('common', 'uncommon', 'rare', 'mythic_rare') NOT NULL,
	`text`      VARCHAR(500)                                       NOT NULL
	COMMENT 'card text, two escaped <br> tags between lines',
	`image`     VARCHAR(200)                                       NOT NULL
	COMMENT 'full url to magicinfo card image',
	`in_deck`   ENUM ('yes', 'no')                                 NOT NULL DEFAULT 'no',
	`foil`		ENUM ('yes', 'no')                                 NOT NULL DEFAULT 'no',
	PRIMARY KEY (`id`)
)
	ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `magic`.`decks` (
	`id`        INT(11)                                  NOT NULL AUTO_INCREMENT,
	`timestamp` TIMESTAMP                                NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`format`    ENUM ('standard', 'modern', 'commander') NOT NULL,
	`name`      VARCHAR(50)                              NOT NULL,
	`cards`     VARCHAR(600)                             NOT NULL
	COMMENT 'csv of card ids, put commander id first (if applicable)',
	PRIMARY KEY (`id`)
)
	ENGINE = INNODB;

-- the next set of queries are for test data population, remove these lines and reinstantiate
-- the database once testing has concluded and real data is being added to the database

INSERT INTO `magic`.`cards` (name, mana, typeline, set, set_number, rarity, text, image, foil) VALUES (
	'Gallows Warden',
	'4W',
	'Creature -- Spirit',
	'isd',
	16,
	'uncommon',
	'Flying <br><br>Other Spirit creatures you control get +0/+1.',
	'http://magiccards.info/scans/en/isd/16.jpg',
	'no'
);

INSERT INTO `magic`.`cards` (name, mana, typeline, set, set_number, rarity, text, image, foil) VALUES (

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

