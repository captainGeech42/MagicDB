CREATE DATABASE IF NOT EXISTS `magic`;

CREATE TABLE IF NOT EXISTS `magic`.`cards` (
	`id`        INT(11)                                             NOT NULL AUTO_INCREMENT,
	`timestamp` TIMESTAMP                                           NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`type`		ENUM ('land', 'creature', 'artifact', 'enchantment', 'planeswalker',
					  'instant', 'sorcery', 'token', 'phenomenon', 'plane',
					  'scheme', 'tribal', 'vanguard', 'conspiracy') NOT NULL,
	`name`      VARCHAR(50)                                         NOT NULL,
	`mana`      VARCHAR(15)                                         NOT NULL,
	`typeline`	VARCHAR(50)                                         NOT NULL,
	`set_abbr`	VARCHAR(10)                                         NOT NULL
	COMMENT 'abbreviated set (i.e. innistrad->isd)',
	`set_number` INT(3)                                             NOT NULL
	COMMENT 'card number in the set',
	`pt`		VARCHAR(10)                                         NOT NULL,
	`rarity`    ENUM ('common', 'uncommon', 'rare', 'mythic_rare')  NOT NULL,
	`text`      VARCHAR(500)                                        NOT NULL
	COMMENT 'card text, two escaped <br> tags between lines',
	`image`     VARCHAR(200)                                        NOT NULL
	COMMENT 'full url to magicinfo card image',
	`in_deck`   ENUM ('yes', 'no')                                  NOT NULL DEFAULT 'no',
	`foil`		ENUM ('yes', 'no')                                  NOT NULL DEFAULT 'no',
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

CREATE TABLE IF NOT EXISTS `magic`.`sets` (
	`id`			INT(11)		NOT NULL AUTO_INCREMENT,
	`timestamp` 	TIMESTAMP	NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`abbreviation` 	VARCHAR(3)	NOT NULL,
	`name`			VARCHAR(50)	NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE = INNODB;

-- the next set of queries are for test data population, remove these lines and reinstantiate
-- the database once testing has concluded and real data is being added to the database
-- DO NOT REMOVE ANY INSERTS TO `magic`.`sets`; THESE ARE NOT PLACEHOLDER VALUES

INSERT INTO `magic`.`cards` (type, name, mana, typeline, set_abbr, set_number, pt, rarity, text, image, foil) VALUES (
	'creature',
	'Gallows Warden',
	'4W',
	'Creature -- Spirit',
	'isd',
	16,
	'3/3',
	'uncommon',
	'Flying <br><br>Other Spirit creatures you control get +0/+1.',
	'http://magiccards.info/scans/en/isd/16.jpg',
	'no'
);

INSERT INTO `magic`.`cards` (type, name, mana, typeline, set_abbr, set_number, pt, rarity, text, image, foil) VALUES (
	'creature',
	'Geist-Honored Monk',
	'3WW',
	'Creature -- Human Monk',
	'isd',
	17,
	'*/*',
	'rare',
	'Vigilance <br><br>Geist-Honored Monk''s power and toughness are each equal to the number of creatures you control. <br><br>When Geist-Honored Monk enters the battlefield, put two 1/1 white Spirit creature tokens with flying onto the battlefield.',
	'http://magiccards.info/scans/en/isd/17.jpg',
	'no'
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

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'10e',
	'Core Set Tenth Edition'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'lw',
	'Lorwyn'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'mt',
	'Morningtide'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'shm',
	'Shadowmoor'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'eve',
	'Eventide'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'ala',
	'Shards of Alara'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'cfx',
	'Conflux'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'arb',
	'Alara Reborn'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'm10',
	'Magic 2010 Core Set'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'zen',
	'Zendikar'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'wwk',
	'Worldwake'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'roe',
	'Rise of the Eldrazi'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'm11',
	'Magic 2011 Core Set'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'som',
	'Scars of Mirrodin'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'mbs',
	'Mirrodin Besieged'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'nph',
	'New Phyrexia'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'm12',
	'Magic 2012 Core Set'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'isd',
	'Innistrad'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'dka',
	'Dark Ascension'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'avr',
	'Avacyn Restored'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'm13',
	'Magic 2013 Core Set'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'rtr',
	'Return to Ravnica'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'gtc',
	'Gatecrash'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'dgm',
	'Dragon''s Maze'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'm14',
	'Magic 2014 Core Set'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'ths',
	'Theros'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'bng',
	'Born of the Gods'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'jou',
	'Journey into Nyx'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'm15',
	'Magic 2015 Core Set'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'ktk',
	'Khans of Tarkir'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'frf',
	'Fate Reforged'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'dtk',
	'Dragons of Tarkir'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'ori',
	'Magic Origins'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'bfz',
	'Battle for Zendikar'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'ogw',
	'Oath of the Gatewatch'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'soi',
	'Shadows over Innistrad'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'emn',
	'Eldritch Moon'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'cn2',
	'Conspiracy: Take the Crown'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'kld',
	'Kaladesh'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'c16',
	'Commander (2016 Edition)'
);


INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'pca',
	'Planechase Anthology'
);

INSERT INTO `magic`.`sets` (abbreviation, name) VALUES (
	'aer',
	'Aether Revolt'
);

CREATE USER 'magicdb'@'%' IDENTIFIED BY 'magic1234';
GRANT ALL PRIVILEGES ON magic.* TO 'magicdb'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;