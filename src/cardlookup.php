<?php
/**
 * Created by Zander Work on 2/7/2017 8:10 PM.
 */

require_once('Database.php');
require_once('PlatesController.php');
require_once('CardScraper.php');

if (isset($_GET['id']) && isset($_GET['set']) && isset($_GET['type'])) {
	$cardScraper = new CardScraper($_GET['id'], $_GET['set'], $_GET['type']);
	$image = $cardScraper->getCardImageURL();
	$cardScraper->scrapCardInfo(true);
	$info = $cardScraper->getCardInfo();

	echo \PlatesController::renderTemplate('cardlookup', ['image' => $image, 'cardInfo' => $info]);
} else {
	//we don't know what card to lookup, present form to the user
	echo \PlatesController::renderTemplate('cardlookupform');
}
?>
