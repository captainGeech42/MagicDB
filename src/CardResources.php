<?php

/**
 * Created by zande on 2/10/2017 1:18 PM.
 */
class CardResources {

	public static $colors = ['B', 'C', 'G', 'R', 'U', 'W', 'X', '1', '2', '3', '4'];
	public static $symbols = ['E', 'T'];

	public static function getManaImg($color) {
		return sprintf('<img src="img/mana_icon/%s.svg" height="15px">', strtoupper($color));
	}

	public static function getSetImg($set) {
		return sprintf('<img src="img/set_icon/%s.png">', $set);
	}

	public static function getSymbolImg($symbol) {
		return sprintf('<img src="img/%s.svg" height="15px">', strtoupper($symbol));
	}
}