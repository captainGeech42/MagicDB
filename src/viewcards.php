<?php
/**
 * Created by Zander Work on 2/7/2017 8:10 PM.
 */

require_once('Database.php');
require_once('PlatesController.php');

$cards = Database::getCardsHTML();

echo PlatesController::renderTemplate('viewcards', ['cards' => $cards]);
?>
