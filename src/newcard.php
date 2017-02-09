<?php
/**
 * Created by Zander Work on 2/7/2017 8:10 PM.
 */

require_once('Database.php');
require_once('PlatesController.php');
require_once('CardScraper.php');

$cardScraper = new CardScraper(17, "isd", CARDTYPE_CREATURE);
$image = $cardScraper->getCardImageURL();

echo \PlatesController::renderTemplate('newcard', ['image' => $image]);
echo '<br><br>';
$cardScraper->scrapCardInfo();
?>
