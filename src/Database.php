<?php
/**
 * Created by Zander Work on 2/7/2017 3:30 PM.
 */

require_once('config.db.php');
require_once('CardScraper.php');

class Database {
	private static $instance = null;

	private function __construct() {
	}

	private function __clone() {
	}

	private static function getInstance() {
		if (self::$instance === null) {
			$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s', DB_HOST, DB_PORT, DB_NAME);
			self::$instance = new PDO($dsn, DB_USER, DB_PASS);
		}
		return self::$instance;
	}

	public static function runSql($sql, $args = []) {
		$stmt = self::getInstance()->prepare($sql);
		$stmt->execute($args);
		return $stmt;
	}

	public static function getCards() {
		$stmt = self::runSql('SELECT name, mana, typeline, set_abbr, rarity, text, image, foil FROM cards;');
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getCardsHTML() {
		$cards = self::getCards();
		foreach ($cards as &$card) {
			foreach (CardScraper::$colors as $color) {
				$card['mana'] = str_replace("{" . $color . "}", '<img src="img/mana_icon/' . $color . '.svg" height=15px>', $card['mana']);
				$card['cardtext'] = str_replace("{" . $color . "}", '<img src="img/mana_icon/' . $color . '.svg" height=15px>', $card['cardtext']);
			}
		}
		return $cards;
	}

	public static function getCard($id) {
		$stmt = self::runSql('SELECT name, mana, typeline, set_abbr, rarity, text, image, foil FROM cards WHERE id = ?;', [$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public static function getCardHTML($id) {
		$card = self::getCard($id);
		foreach (CardScraper::$colors as $color) {
			echo 'replacing ' . $color . '<br>';
			$card['mana'] = str_replace("{" . $color . "}", '<img src="img/mana_icon/' . $color . '.svg" height=15px>', $card['mana']);
			$card['cardtext'] = str_replace("{" . $color . "}", '<img src="img/mana_icon/' . $color . '.svg" height=15px>', $card['cardtext']);
		}
		return $card;
	}

	public static function getDecks() {
		$stmt = self::runSql('SELECT format, name, cards FROM decks;');
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getDeck($id) {
		$stmt = self::runSql('SELECT format, name, cards FROM decks WHERE id = ?;', [$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public static function getSets() {
		$stmt = self::runSql('SELECT abbreviation, name FROM sets ORDER BY name;');
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getSet($id) {
		$stmt = self::runSql('SELECT abbreviation, name FROM sets WHERE id = ?;', [$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	//TODO overload this to take an assoc array of card data (CardScraper::getCardInfo())
	public static function addCard($name, $mana, $typeline, $set_name, $rarity, $text, $image, $foil) {
		self::runSql('INSERT INTO cards (name, mana, rarity, image, text, typeline, set_name, foil) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
					 [$name, $mana, $rarity, $image, $text, $typeline, $set_name, $foil]);
	}

	public static function addCardFromArray($cardData) {
		self::addCard($cardData['name'], $cardData['mana'], $cardData['typeline'], $cardData['setName'],
				$cardData['rarity'], $cardData['text'], $cardData['image'], $cardData['foil']);
	}
}