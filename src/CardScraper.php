<?php

/**
 * Created by Zander Work on 2/7/2017 11:29 PM.
 */
class CardScraper {

	private $typeline; //Creature - Human Monk
	private $mana; //3WW
	private $pt; //*/*
	private $cardtext; //Lots of long text
	private $number; //17 (in xxx/yyy, this is the xxx)
	private $set; //ISD

	public function __construct($number, $set) {
		$this->$number = $number;
		$this->$set = $set;
	}

	public function setCardInfo() {
		
	}

}