<?php

/**
 * Created by Zander Work on 2/7/2017 11:29 PM.
 */

define('CARDTYPE_CREATURE', 1);
//TODO add more card types

class CardScraper {

	private $name; //Geist-Honored Monk
	private $typeline; //Creature - Human Monk
	private $mana; //3WW
	private $pt; //*/* or 5/3 or (maybe) 15/100
	private $cardtext = ''; //Lots of long text
	private $number; //17 (in xxx/yyy on bottom of a card, this is the xxx)
	private $set; //ISD
	private $type; //corresponding integer to type of card (see top of file)

	public function __construct($number, $set, $type) {
		$this->number = $number;
		$this->set = $set;
		$this->type = $type;
	}

	private function getCardInfoURL() {
		return sprintf("http://magiccards.info/%s/en/%s.html", $this->set, $this->number);
	}

	public function getCardImageURL() {
		return sprintf("http://magiccards.info/scans/en/%s/%s.jpg", $this->set, $this->number);
	}

	private function getHTML($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36");
		$htmlData = curl_exec($curl);

		if ($htmlData) {
			echo 'got valid HTML data from curl<br>';
			return $htmlData;
		} else {
			echo 'got invalid HTML data from curl<br>';
			return false;
		}
	}

	public function scrapCardInfo() {
		if ($this->type != 1) {
			echo 'invalid card type given. only creatures are currently supported. <br>';
			return false;
		}
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

						//get the row
						$td = $domXpath->query('//td[@valign="top" and @style="padding: 0.5em;" and @width="70%"]', $table);
						echo 'td length: ' . $td->length . '<br>';

						$nameNodeList = $domXpath->query('span[@style="font-size: 1.5em;"]/a', $td->item(0));
						$this->name = $nameNodeList->item(0)->nodeValue;
						echo "\$this->name = " . $this->name . '<br>';

						$infoComboLineNodeList = $domXpath->query('p', $td->item(0));
						$infoComboLine = $infoComboLineNodeList->item(0)->nodeValue;

						$infoComboLineCommaSplit = explode(',', $infoComboLine);
						//[0] is name and p/t, [1] is mana and a (seemingly) random number in parantheses that we don't care about
						//[0]=Creature — Human Monk */*
						//[1]=3WW (5)

						$this->mana = explode(' ', trim($infoComboLineCommaSplit[1]))[0];
						echo "\$this->mana = " . $this->mana . '<br>';

						if (strpos($infoComboLineCommaSplit[0], '*') !== false) {
							//card has indefinite p/t, so we know the length of p/t
							echo 'card has indefinite p/t<br>';
							$this->pt = '*/*';
							$this->typeline = substr($infoComboLineCommaSplit[0], 0, strlen($infoComboLineCommaSplit[0]) - 4);
						} else {
							//card has definite p/t, unknown length
							echo 'card has definite p/t [' . $infoComboLineCommaSplit[0] . ']<br>';
							$split = explode(' ', $infoComboLineCommaSplit[0]);
							$this->pt = array_pop($split);
							$typeline = '';
							foreach($split as $word) {
								$typeline .= $word . ' ';
							}
							$this->typeline = $typeline;
						}
						$this->typeline = str_replace('—',  '--', $this->typeline);

						echo "\$this->pt = " . $this->pt . '<br>';
						echo "\$this->typeline = " . $this->typeline . '<br>';

						$ctextNode = $domXpath->query('p[@class="ctext"]', $td->item(0))->item(0)->nodeValue;

						//split on space
						//foreach, split on ''
						//foreach, if there are more than one capital letter, put a <br>x2 in
						$ctextsplit = explode(' ', $ctextNode);
						$ctextarraycounter = 0;

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
											//if the last character was a -, we don't want a linebreak, because Geist-Honored can be one line
											$ctextsplit[$ctextarraycounter] = substr_replace($word, '<br><br>', $offset, 0);
										}
									}
									$capitalCounter = 0;
								}
								if ($previousChar === '.') {
									//we hit the end of a sentence. it is most likely now a new line
									$ctextsplit[$ctextarraycounter] = substr_replace($word, '<br><br>', $offset, 0);
								}
								$previousChar = $char;
							}
							$ctextarraycounter++;
						}

						//recombine the card text
						foreach ($ctextsplit as $word) {
							$this->cardtext .= $word . ' ';
						}

						echo "\$this->cardtext = " . '<br>' . $this->cardtext . '<br>';

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