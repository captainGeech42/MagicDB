<?php

require_once('vendor/autoload.php');

define("TEMPLATE_DIR", "templates/");

/**
 * Created by Zander Work on 2/7/2017 6:35 PM.
 */
class PlatesController {

	private static $templates = NULL;

	private function __construct() {

	}

	public static function getInstance() {
		if (self::$templates === NULL) {
			self::$templates = new \League\Plates\Engine(TEMPLATE_DIR, 'tpl.php');
		}
		return self::$templates;
	}

	public static function renderTemplate($template, $args = []) {
		return self::getInstance()->render($template, $args);
	}

	public static function makeTemplate($template) {
		return self::getInstance()->make($template);
	}
}