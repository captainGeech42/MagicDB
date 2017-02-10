<?php

/**
 * Created by Zander Work on 2/7/2017 11:29 PM.
 */

//define('CARDTYPE_BASIC_LAND', 0); basic lands are parsed the same as lands, no need to differentiate them b/c they are similar
define('CARDTYPE_LAND', 1);
define('CARDTYPE_CREATURE', 2);
define('CARDTYPE_ARTIFACT', 3);
define('CARDTYPE_ENCHANTMENT', 4);
define('CARDTYPE_PLANESWALKER', 5);
define('CARDTYPE_INSTANT', 6);
define('CARDTYPE_SORCERY', 7);
define('CARDTYPE_TOKEN', 8);
define('CARDTYPE_PHENOMENON', 9);
define('CARDTYPE_PLANE', 10);
define('CARDTYPE_SCHEME', 11);
define('CARDTYPE_TRIBAL', 12);
define('CARDTYPE_VANGUARD', 13);
define('CARDTYPE_CONSPIRACY', 14);

class CardScraper {

	private $name; //Geist-Honored Monk
	private $typeline; //Creature -- Human Monk
	private $mana; //3WW
	private $pt; //*/* or 5/3 or (maybe) 15/100
	private $cardText = ''; //Lots of long text
	private $number; //17 (in xxx/yyy on bottom of a card, this is the xxx)
	private $setName; //ISD
	private $cardType; //corresponding integer to type of card (see top of file)

	public function __construct($number, $set, $cardType) {
		$this->number = $number;
		$this->setName = $set;
		$this->cardType = $cardType;
	}

	public function getCardImageURL() {
		return sprintf("http://magiccards.info/scans/en/%s/%s.jpg", strtolower($this->setName), $this->number);
	}

	private function getCardInfoURL() {
		return sprintf("http://magiccards.info/%s/en/%s.html", strtolower($this->setName), $this->number);
	}

	public function getCardInfo() {
		return ['name' => $this->name,
				'typeline' => $this->typeline,
				'mana' => $this->mana,
				'pt' => $this->pt,
				'cardtext' => $this->cardText,
				'number' => $this->number,
				'setName' => $this->setName,
				'cardType' => $this->cardType];
	}

	private function getHTML($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36");
		$htmlData = curl_exec($curl);

		if ($htmlData) {
//			echo 'got valid HTML data from curl<br>';
			return $htmlData;
		} else {
			echo 'got invalid HTML data from curl<br>';
			return false;
		}
	}

	public function scrapCardInfo() {
		$html = $this->getHTML($this->getCardInfoURL());
		$domDocument = new DOMDocument();

		libxml_use_internal_errors(true); //silence errors for bad HTML

		if ($html !== false) {
			//make sure we actually got the webpage data
			$domDocument->loadHTML($html);
			libxml_clear_errors();

			$domXpath = new DOMXPath($domDocument);

			//get all tables from the page
			$tables = $domXpath->query('//table');

			if ($tables->length > 0) {
				//we found at least one table
				$counter = 0;
				foreach ($tables as $table) {
					if ($counter == 3) {
						//we only want the fourth table to be used, as it has the info for our card

						//TODO IMPORTANT: THIS ONLY WORKS FOR CREATURE CARDS RIGHT NOW, EVENTUALLY IT WILL BE EXPANDED TO ALL

						if ($this->cardType == CARDTYPE_LAND ||
							$this->cardType == CARDTYPE_CREATURE) {
							//get the row
							$td = $domXpath->query('//td[@valign="top" and @style="padding: 0.5em;" and @width="70%"]', $table);

							$nameNodeList = $domXpath->query('span[@style="font-size: 1.5em;"]/a', $td->item(0));
							$this->name = $nameNodeList->item(0)->nodeValue;

							$infoComboLineNodeList = $domXpath->query('p', $td->item(0));
							$infoComboLine = $infoComboLineNodeList->item(0)->nodeValue;

							$infoComboLineCommaSplit = explode(',', $infoComboLine);
							//[0] is name and p/t, [1] is colored mana representation and total mana in parantheses that we don't care about
							//[0]=Creature — Human Monk */*
							//[1]=3WW (5)

							$this->mana = explode(' ', trim($infoComboLineCommaSplit[1]))[0];

							if (strpos($infoComboLineCommaSplit[0], '*') !== false) {
								//card has indefinite p/t, so we know the length of p/t
								$this->pt = '*/*';
								$this->typeline = substr($infoComboLineCommaSplit[0], 0, strlen($infoComboLineCommaSplit[0]) - 4);
							} else {
								//card has definite p/t, unknown length
								$split = explode(' ', $infoComboLineCommaSplit[0]);
								$this->pt = array_pop($split);
								$typeline = '';
								foreach($split as $word) {
									$typeline .= $word . ' ';
								}
								$this->typeline = $typeline;
							}
							$this->typeline = str_replace('—',  '--', $this->typeline);

							$ctextNode = $domXpath->query('p[@class="ctext"]', $td->item(0))->item(0)->nodeValue;

							//split on space
							//foreach, split on ''
							//foreach, if there are more than one capital letter, put a <br>x2 in
							$ctextsplit = explode(' ', $ctextNode);
							$ctextarraycounter = 0;

							//TODO issue: mulitple keywords on one line don't follow the capitalization assumption:
							//cardlookup.php?set=isd&id=13
							//possible solution: have an array of all possible keywords, check if any of them are present in $word

							foreach ($ctextsplit as $word) {
								$capitalCounter = 0;
								$offset = -1;
								$previousChar = null;
								foreach (str_split($word) as $char) {
									$offset++;
									if (ctype_upper($char)) {
										$capitalCounter++;
									}
									if ($capitalCounter > 1) {
										//there have been two capitals since the last inserted line break
										if ($previousChar != null) {
											//this isn't the first letter
											//it shouldn't be possible for this check to fail, but better safe than sorry
											if ($previousChar !== '-') {
												//if the last character was a -, we don't want a linebreak,
												//because Geist-Honored can be one line
												$ctextsplit[$ctextarraycounter] = substr_replace($word, '<br><br>', $offset, 0);
											}
										}
										$capitalCounter = 0;
									}
									if (strcmp($previousChar, '.') === 0 && strcmp($char, ')') !== 0) {
										//we hit the end of a sentence. it is most likely now a new line (unless the next character is a close paren
										$ctextsplit[$ctextarraycounter] = substr_replace($word, '<br><br>', $offset, 0);

										//TODO period inside a parenthese suoldn't trigger a new line.
										//Disregarding this example is an instant, this may be an issue:
										//cardlookup.php?set=isd&id=13
									}
									$previousChar = $char;
								}
								$ctextarraycounter++;
							}

							//recombine the card text
							foreach ($ctextsplit as $word) {
								$this->cardText .= $word . ' ';
							}

							//check if we have an empty card text
							if (strcmp($this->cardText, ' ') === 0) {
								$this->cardText = '[no cardtext]';
							}
						}
						else if ($this->cardType == CARDTYPE_ARTIFACT) {
							
						} else {
							echo 'card type not supported yet...';
						}

						//we did the only table we care about, no need to continue the loop
						break;
					}
					$counter++;
				}
			} else {
				//there weren't any tables
				echo 'There were no &lt;table&gt; found on the page ' . $this->getCardInfoURL() . '<br>';
			}
		} else {
			//we couldn't get the webpage data
			echo 'The page: ' . $this->getCardInfoURL() . ' is currently unaccessible (check cURL headers?)</br>';
		}
	}
}