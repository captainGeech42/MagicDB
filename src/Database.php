<?php
/**
 * Created by Zander Work on 2/7/2017 3:30 PM.
 */

require_once('config.db.php');

class Database {
	private static $instance = null;

	private function __construct() {
	}

	private function __clone() {
	}

	public static function getInstance() {
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
		$stmt = self::runSql('SELECT name, mana, rarity, in_deck, image, text FROM cards;');
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getCard($id) {
		$stmt = self::runSql('SELECT name, mana, rarity, in_deck, image, text FROM cards WHERE id = ?', [$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public static function getDecks() {
		$stmt = self::runSql('SELECT format, name, cards FROM decks;');
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getDeck($id) {
		$stmt = self::runSql('SELECT format, name, cards FROM decks WHERE id = ?', [$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public static function addCard($name, $mana, $rarity, $image, $text) {
		self::runSql('INSERT INTO cards (name, mana, rarity, in_deck, image, text) VALUES (?, ?, ?, \'no\', ?, ?)',
					 [$name, $mana, $rarity, $image, $text]);
	}
}